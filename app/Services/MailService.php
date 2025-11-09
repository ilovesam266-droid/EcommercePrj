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

class MailService
{
    protected MailRepositoryInterface $mailRepository;
    protected MailRecipientRepositoryInterface $mailRecipientRepository;
    public function __construct(MailRepositoryInterface $mail_repository, MailRecipientRepositoryInterface $mail_recipient_repository)
    {
        $this->mailRepository = $mail_repository;
        $this->mailRecipientRepository = $mail_recipient_repository;
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
            $variables = [
                'fullname' => $recipient->fullname,
                'order_id' => $order->id,
                'cancel_reason' => $order->cancel_reason ?? 'Customer request',
                'app_name' => config('app.name'),
            ];

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

        $template = $this->mailRepository->findByType('order_confirmed');

        if ($template) {
            $variables = [
                'fullname' => $recipient->fullname,
                'order_id' => $order->id,
                'app_name' => config('app.name'),
            ];

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
            $variables = [
                'fullname' => $recipient->fullname,
                'order_id' => $order->id,
                'app_name' => config('app.name'),
            ];

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
            $variables = [
                'fullname' => $recipient->fullname,
                'order_id' => $order->id,
                'failed_reason' => $order->failure_reason ?? 'Customer request',
                'app_name' => config('app.name'),
            ];

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
            $variables = [
                'fullname' => $recipient->fullname,
                'order_id' => $order->id,
                'done_at' => $order->done_at,
                'app_name' => config('app.name'),
            ];

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
