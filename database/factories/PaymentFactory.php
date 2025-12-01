<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    public function definition(): array
    {
        $order = Order::inRandomOrder()->first();

        return [
            'order_id' => $order->id,
            'user_id' => User::inRandomOrder()->first()?->id ?? 1,
            'amount' => $order->total_amount,
            'payment_method' => $this->faker->randomElement(PaymentMethod::cases() ?? ['cod', 'paypal', 'credit card', 'bank_transfer', 'stripe']),
            'transaction_code' => strtoupper(Str::random(10)),
            'status' =>  $this->faker->randomElement(PaymentStatus::cases() ?? ['pending', 'complete', 'failed', 'refund']),
            'metadata' => json_encode([
                'note' => $this->faker->sentence(),
                'ref' => $this->faker->uuid(),
            ]),
        ];
    }
}
