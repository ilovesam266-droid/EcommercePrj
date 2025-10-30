<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\ProductVariantSize;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $variant = ProductVariantSize::inRandomOrder()->first();
        return [
            'order_id' => Order::inRandomOrder()->first()?->id ?? 1,
            'product_variant_size_id' => $variant->id,
            'quantity' => $this->faker->numberBetween(1, 5),
            'unit_price' => $variant->price,
        ];
    }
}
