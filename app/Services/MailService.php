<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\OrderFailedMail;
use App\Mail\OrderShippingMail;
use App\Mail\OrderCancelledMail;
use App\Mail\OrderConfirmedMail;
use App\Mail\OrderDoneMail;
use App\Repository\Constracts\MailRecipientRepositoryInterface;
use App\Repository\Constracts\MailRepositoryInterface;
use Illuminate\Support\Facades\Log;

use function Symfony\Component\Clock\now;

class MailService
{
    protected MailRepositoryInterface $mailRepository;
    protected MailRecipientRepositoryInterface $mailRecipientRepository;
    public function __construct(MailRepositoryInterface $mail_repository, MailRecipientRepositoryInterface $mail_recipient_repository)
    {
        $this->mailRepository = $mail_repository;
        $this->mailRecipientRepository = $mail_recipient_repository;
    }

    private function buildOrderVariables($order)
    {
        $recipient = $order->owner;

        // Map product details
        $products = $order->orderItems->map(function ($item) {
            $image = $item->productVariantSize?->product?->images->first();
            $thumbnailBase64 = null;

            if ($image && !empty($image->url)) {
                $fullPath = storage_path('app/public/' . $image->url);

                if (file_exists($fullPath)) {
                    $thumbnailBase64 = $this->resizeImageToBase64($fullPath, 200, 200, 70);
                }
            } else {
                return null;
            }

            return [
                'name' => $item->productVariantSize?->product?->name ?? 'Product is not valid',
                'price' => number_format($item->unit_price),
                'quantity' => $item->quantity,
                'subtotal' => number_format($item->unit_price * $item->quantity),
                'thumbnail' => $thumbnailBase64 ?? null,
                'sku' => $item->productVariantSize?->sku ?? null,
                'variant' => $item->productVariantSize?->variant_size ?? null,
            ];
        })->toArray();

        return [
            // customer info
            'fullname' => $recipient->fullname,
            'email' => $recipient->email,
            'address' => $order->detailed_address ?? '',

            // order info
            'order_id' => $order->id,
            'order_code' => '#' . $order->id,
            'order_status' => $order->status,
            'subtotal' => number_format($order->subtotal),
            'order_total' => number_format($order->total_amount),

            'payment_method' => $order->payment->payment_method,
            'payment_status' => $order->payment->status,

            // links
            'app_name' => config('app.name'),
            'app_url' => config('app.url'),
            'order_url' => config('app.url') . '/orders/' . $order->id,

            // list products
            'products' => $products,
        ];
    }

    private function resizeImageToBase64(string $path, int $w = 200, int $h = 200, int $quality = 70): ?string
    {
        $info = getimagesize($path);
        if (!$info) return null;

        switch ($info['mime']) {
            case 'image/jpeg':
                $src = imagecreatefromjpeg($path);
                break;
            case 'image/png':
                $src = imagecreatefrompng($path);
                break;
            case 'image/webp':
                $src = imagecreatefromwebp($path);
                break;
            default:
                return null;
        }

        $dst = imagecreatetruecolor($w, $h);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, imagesx($src), imagesy($src));

        ob_start();
        imagejpeg($dst, null, $quality);
        $imageData = ob_get_clean();

        imagedestroy($src);
        imagedestroy($dst);

        return "data:image/jpeg;base64," . base64_encode($imageData);
    }

    public function buildMailRecipientData($recipient, $template, $status = 'unread', $error = null)
    {
        $data = [
            'user_id' => $recipient->id,
            'mail_id' => $template->id,
            'email' => $recipient->email,
            'status' => $status,
            'sent_at' => now(),
        ];

        if ($error) {
            $data['error_message'] = $error;
        }

        return $data;
    }

    public function sendOrderCancelledMail($order): void
    {
        $recipient = $order->owner;

        $template = $this->mailRepository->findByType('order_canceled');

        if ($template) {
            $variables = array_merge($this->buildOrderVariables($order), [
                'cancel_reason' => $order->cancellation_reason ?? 'Customer request',
                'canceled_at' => $order->canceled_at ?? now(),
            ]);

            try {
                Mail::to($recipient->email)->sendNow(new OrderCancelledMail($template, $variables));
                $mailRecipientData = $this->buildMailRecipientData($recipient, $template, 'unread');
            } catch (\Throwable $e) {
                $mailRecipientData = $this->buildMailRecipientData($recipient, $template, 'failed', $e->getMessage());
            }
            $this->mailRecipientRepository->create($mailRecipientData);
        }
    }

    public function sendOrderConfirmedMail($order): void
    {
        $recipient = $order->owner;

        $template = array_merge($this->buildOrderVariables($order), [
                'confirmed_at' => $order->confirmed_at ?? now(),
            ]);

        if ($template) {
            $variables = $this->buildOrderVariables($order);

            try {
                Mail::to($recipient->email)->sendNow(new OrderConfirmedMail($template, $variables));
                $mailRecipientData = $this->buildMailRecipientData($recipient, $template, 'unread');
            } catch (\Throwable $e) {
                $mailRecipientData = $this->buildMailRecipientData($recipient, $template, 'failed', $e->getMessage());
            }
            $this->mailRecipientRepository->create($mailRecipientData);
        }
    }

    public function sendOrderShippingMail($order): void
    {
        $recipient = $order->owner;

        $template = $this->mailRepository->findByType('order_shipping');

        if ($template) {
            $variables = array_merge($this->buildOrderVariables($order), [
                'shipping_at' => $order->shipping_at ?? now(),
            ]);

            try {
                Mail::to($recipient->email)->sendNow(new OrderShippingMail($template, $variables));
                $mailRecipientData = $this->buildMailRecipientData($recipient, $template, 'unread');
            } catch (\Throwable $e) {
                $mailRecipientData = $this->buildMailRecipientData($recipient, $template, 'failed', $e->getMessage());
            }
            $this->mailRecipientRepository->create($mailRecipientData);
        }
    }

    public function sendOrderFailedMail($order): void
    {
        $recipient = $order->owner;

        $template = $this->mailRepository->findByType('order_failed');

        if ($template) {
            $variables = array_merge($this->buildOrderVariables($order), [
                'failed_reason' => $order->failure_reason ?? 'Customer request',
                'failed_at' => $order->failed_at ?? now(),
            ]);

            try {
                Mail::to($recipient->email)->sendNow(new OrderFailedMail($template, $variables));
                $mailRecipientData = $this->buildMailRecipientData($recipient, $template, 'unread');
            } catch (\Throwable $e) {
                $mailRecipientData = $this->buildMailRecipientData($recipient, $template, 'failed', $e->getMessage());
            }
            $this->mailRecipientRepository->create($mailRecipientData);
        }
    }

    public function sendOrderDoneMail($order): void
    {
        $recipient = $order->owner;

        $template = $this->mailRepository->findByType('order_done');

        if ($template) {
            $variables = array_merge($this->buildOrderVariables($order), [
            'shipping_at' => $order->shipping_at,
            'order_date' => $order->created_at,
            'delivered_date' => $order->done_at,
        ]);

            try {
                Mail::to($recipient->email)->sendNow(new OrderDoneMail($template, $variables));
                $mailRecipientData = $this->buildMailRecipientData($recipient, $template, 'unread');
            } catch (\Throwable $e) {
                $mailRecipientData = $this->buildMailRecipientData($recipient, $template, 'failed', $e->getMessage());
            }
            $this->mailRecipientRepository->create($mailRecipientData);
        }
    }
}
