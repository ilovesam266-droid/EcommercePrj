<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\User;
use App\Models\Category;
use App\Models\Payment;
use Illuminate\Support\Str;
use App\Models\Order;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $province = fake()->state();
        $district = fake()->city();
        $ward = fake()->citySuffix();
        $detailed_address = fake()->streetAddress();
        return [
            'owner_id' => User::inRandomOrder()->first()?->id ?? 1,
            'total_amount' => $this->faker->numberBetween(50000, 5000000),
            'recipient_name' => $this->faker->name(),
            'recipient_phone' => '0' . $this->faker->numberBetween(100000000, 999999999),
            'shipping_fee' => $this->faker->numberBetween(0, 50000),
            'province' => $province,
            'district' => $district,
            'ward' => $ward,
            'detailed_address' => $detailed_address,
            'status' => $this->faker->randomElement(OrderStatus::cases() ?? ['pending', 'confirmed', 'shipped', 'delivered']),
            'customer_note' => $this->faker->optional()->sentence(),
            'admin_note' => $this->faker->optional()->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
    public function withItems(int $count = 3)
    {
        return $this->afterCreating(function (Order $order) use ($count) {
            // Tạo các order items
            $items = \App\Models\OrderItem::factory($count)->create([
                'order_id' => $order->id,
            ]);

            // Tính tổng tiền
            $total = $items->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            // Cập nhật lại total_amount
            $order->update([
                'total_amount' => $total,
            ]);
            Payment::factory()->create([
                'order_id' => $order->id,
                'user_id' => $order->owner_id,
                'amount' => $total,
                'payment_method' => $this->faker->randomElement(PaymentMethod::cases() ?? ['cod', 'paypal', 'credit card', 'bank_transfer']),
                'transaction_code' => strtoupper(Str::random(10)),
                'status' => $this->faker->randomElement(PaymentStatus::cases() ?? ['pending', 'complete', 'failed', 'refund']),
                'metadata' => json_encode([
                    'note' => $this->faker->sentence(),
                    'ref' => $this->faker->uuid(),
                ]),
            ]);
        });
    }
}
