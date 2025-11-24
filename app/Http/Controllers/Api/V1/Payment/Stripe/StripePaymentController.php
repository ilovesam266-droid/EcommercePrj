<?php

namespace App\Http\Controllers\Api\V1\Payment\Stripe;

use Stripe\Stripe;
use Stripe\StripeClient;
use App\Http\Controllers\Controller;
use App\Repository\Constracts\OrderRepositoryInterface;
use App\Repository\Constracts\PaymentRepositoryInterface;
use Illuminate\Http\Request;

class StripePaymentController extends Controller
{
    public function __construct(
        protected OrderRepositoryInterface $orders,
        protected PaymentRepositoryInterface $payments
    ) {}

    public function createPaymentIntent(Request $request)
    {
        $request->validate(['order_id' => 'required|integer']);

        $order = $this->orders->find((int) $request->order_id);
        // dd($order);
        if (!$order) return response()->json(['error' => 'order not found'], 404);

        if ($order->status == 'done') {
            return response()->json(['error' => 'order already paid'], 400);
        }

        // lấy hoặc tạo payment
        $payment = $this->payments->firstOrCreate([
            'order_id' => $order->id
        ], [
            'user_id' => $order->owner_id,
            'amount' => $order->total_amount,
            'payment_method' => 'stripe',
            'status' => 'pending'
        ]);

        $stripe = new StripeClient(config('stripe.secret'));

        // nếu chưa có payment_intent thì tạo mới
        if (!$payment->transaction_code) {
            $pi = $stripe->paymentIntents->create([
                'amount' => $order->total_amount, // nhớ là đơn vị cents
                'currency' => 'usd',
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never', // không cho phép redirect
                ],

                'payment_method' => 'pm_card_visa', // test card
                'confirm' => true,

                'metadata' => ['order_id' => $order->id],
                'return_url' => 'https://your-site.com/payment-complete',
            ]);

            $this->payments->update($payment->id, [
                'transaction_code' => $pi->id
            ]);

            $clientSecret = $pi->client_secret;
        } else {
            // retrieve lại paymentintent
            $pi = $stripe->paymentIntents->retrieve($payment->transaction_code);
            $clientSecret = $pi->client_secret ?? null;
        }

        return response()->json([
            'client_secret' => $clientSecret
        ]);
    }
}
