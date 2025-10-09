<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->word(2, true);
        return [
            'name'=> $name,
            'slug'=> \Str::slug($name),
            'created_by' => User::inRandomOrder()->first()?->id ?? 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
