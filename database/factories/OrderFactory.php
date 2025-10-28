<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\OrderStatus;
use App\Models\User;
use App\Models\Category;
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
            'recipient_phone' => $this->faker->phoneNumber(),
            'shipping_fee' => $this->faker->numberBetween(0, 50000),
            'province' => $province,
            'district' => $district,
            'ward' => $ward,
            'detailed_address' => $detailed_address,
            'payment_method' => $this->faker->randomElement([0, 1, 2]),
            'payment_status' => $this->faker->randomElement([0, 1]),
            'payment_transaction_code' => $this->faker->uuid(),
             'status' => $this->faker->randomElement(OrderStatus::cases() ?? ['pending', 'confirmed', 'shipped', 'delivered']),
            'customer_note' => $this->faker->optional()->sentence(),
            'admin_note' => $this->faker->optional()->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
