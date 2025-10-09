<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\VariantSize;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariantSize>
 */
class ProductVariantSizeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();
        $variant = VariantSize::inRandomOrder()->first();

        $sku = strtoupper(Str::slug($product?->name ?? 'product')) . '-' . ($variant?->size ?? 0);

        return [
            'product_id' => $product?->id ?? 1,
            'variant_size_id' => $variant?->id ?? 1,
            'sku' => $sku,
            'price' => $this->faker->numberBetween(100000, 1000000),
            'total_sold' => $this->faker->numberBetween(0, 500),
            'stock' => $this->faker->numberBetween(0, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
