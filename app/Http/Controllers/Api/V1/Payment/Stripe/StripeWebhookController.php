<?php

namespace App\Http\Controllers\Api\V1\Payment\Stripe;


use Stripe\Webhook;
use Stripe\StripeClient;
use App\Http\Controllers\Controller;
use App\Repository\Constracts\PaymentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\info;

class StripeWebhookController extends Controller
{
    public function __construct(
        protected PaymentRepositoryInterface $payments
    ) {}

    public function handle(Request $request)
    {
        Log::info('Webhook headers', $request->headers->all());
        Log::info('Stripe-Signature:', [$request->header('Stripe-Signature')]);
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()], 400);
        }

        switch ($event->type) {

            case 'payment_intent.succeeded':
                $pi = $event->data->object;
                $this->handleSuccess($pi);
                break;

            case 'payment_intent.payment_failed':
                $pi = $event->data->object;
                $this->handleFailed($pi);
                break;

            case 'charge.refunded':
                $charge = $event->data->object;
                $this->handleRefund($charge);
                break;
        }

        return response()->json(['received' => true]);
    }

    protected function handleSuccess($pi)
    {
        $payment = $this->payments->findByTransactionCode($pi->id);
        if (!$payment) return;

        $this->payments->update($payment->id, [
            'status' => 'completed',
            'metadata' => $pi
        ]);
    }

    protected function handleFailed($pi)
    {
        $payment = $this->payments->findByTransactionCode($pi->id);
        if (!$payment) return;

        $this->payments->update($payment->id, [
            'status' => 'failed',
            'metadata' => $pi
        ]);
    }

    protected function handleRefund($charge)
    {
        $payment = $this->payments->findByTransactionCode($charge->payment_intent);
        if (!$payment) return;

        $this->payments->update($payment->id, [
            'status' => 'refunded',
            'metadata' => $charge
        ]);
    }
}
