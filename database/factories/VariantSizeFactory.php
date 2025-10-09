<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VariantSize>
 */
class VariantSizeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
            'name' => $this->faker->randomElement(['XS', 'S', 'M', 'L', 'XL', 'XXL']),
            'size' => $this->faker->numberBetween(35, 45),
            'created_by' => User::inRandomOrder()->first()?->id ?? 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
