<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
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
        $name = fake()->unique()->word(3, true);
        $phone = '0' . fake()->numberBetween(100000000, 999999999);
        $province = fake()->state();
        $district = fake()->city();
        $ward = fake()->citySuffix();
        $detailed_address = fake()->streetAddress();
        $payment_methods = ['cod', 'banking', 'momo'];
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];
        return [
            'owner_id' => User::inRandomOrder()->first()?->id ?? 1,
            'name' => $name,
            'phone' => $phone,
            'province' => $province,
            'district' => $district,
            'ward' => $ward,
            'detailed_address' => $detailed_address,
            'payment_method' => fake()->randomElement($payment_methods),
            'status' => fake()->randomElement($statuses),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
