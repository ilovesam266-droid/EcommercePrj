<?php

namespace App\Http\Controllers\Api\V1\Payment\Stripe;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Stripe\Stripe;
use Stripe\StripeClient;
use App\Http\Controllers\Controller;
use App\Repository\Constracts\OrderRepositoryInterface;
use App\Repository\Constracts\PaymentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PHPOpenSourceSaver\JWTAuth\Exceptions\PayloadException;

class StripePaymentController extends Controller
{
    public function __construct(
        protected OrderRepositoryInterface $orders,
        protected PaymentRepositoryInterface $payments
    ) {}

    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
            'payment_method' => 'required|string|in:' . PaymentMethod::STRIPE->value . ',' . PaymentMethod::CASH->value,
        ]);

        $order = $this->orders->find((int) $request->order_id);

        if (!$order) return response()->json(['error' => 'order not found'], 404);

        if ($order->status == OrderStatus::DONE) {
            return response()->json(['error' => 'order already paid'], 400);
        }

        if ($request->payment_method ==  PaymentMethod::STRIPE->value) {
            $payment = $this->payments->firstOrCreate([
                'order_id' => $order->id,
                'payment_method' => PaymentMethod::STRIPE->value,
            ], [
                'user_id' => $order->owner_id,
                'amount' => $order->total_amount,
                'payment_method' => PaymentMethod::STRIPE->value,
                'status' => PaymentStatus::PENDING,
            ]);

            $stripe = new StripeClient(config('stripe.secret'));

            if (!$payment->transaction_code) {
                $pi = $stripe->paymentIntents->create([
                    'amount' => $order->total_amount,
                    'currency' => 'usd',

                    'automatic_payment_methods' => [
                        'enabled' => true,
                        'allow_redirects' => 'never',
                    ],

                    // 'payment_method' => 'pm_card_visa',
                    // 'confirm' => true,
                    // 'return_url' => 'https://your-site.com/payment-complete',

                    'metadata' => ['order_id' => $order->id],
                ]);

                $this->payments->update($payment->id, [
                    'transaction_code' => $pi->id
                ]);

                $clientSecret = $pi->client_secret;
            } else {
                $pi = $stripe->paymentIntents->retrieve($payment->transaction_code);
                $clientSecret = $pi->client_secret ?? null;
            }

            return response()->json([
                'client_secret' => $clientSecret
            ]);
        } elseif ($request->payment_method == PaymentMethod::CASH->value) {
            $payment = $this->payments->firstOrCreate([
                'order_id' => $order->id,
                'payment_method' => PaymentMethod::CASH->value,
            ], [
                'user_id' => $order->owner_id,
                'amount' => $order->total_amount,
                'payment_method' => PaymentMethod::CASH->value,
                'status' => PaymentStatus::PENDING->value,
            ]);

            $this->orders->update($order->id, [
                'status' => OrderStatus::PENDING->value,
                'confirmed_at' => now()
            ]);

            return response()->json([
                'message' => 'payment created',
                'payment_id' => $payment->id,
                'order_status' => OrderStatus::PENDING->value
            ]);
        }
    }

    public function confirmPaymentIntent(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|int',
        ]);

        $payment = $this->payments->find((int)$request->payment_id);
        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        $stripe = new StripeClient(config('stripe.secret'));
        try {
            $pi = $stripe->paymentIntents->retrieve($payment->transaction_code);
            Log::info($pi->status == 'requires_payment_method');
            if ($pi->status == 'requires_payment_method') {
                $pi = $stripe->paymentIntents->confirm($payment->transaction_code, [
                    'payment_method' => 'pm_card_visa',
                ]);
            }

            return response()->json([
                'transaction_code' => $pi->id,
                'status' => $pi->status,
                'client_secret' => $pi->client_secret,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
