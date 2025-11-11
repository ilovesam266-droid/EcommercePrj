<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement(['pending', 'approved', 'rejected']);
        $approvedAt = $status === 'approved' ? $this->faker->dateTimeBetween('-1 month', 'now') : null;
        $approvedBy = $status === 'approved' ? User::inRandomOrder()->first()->id ?? null : null;

        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'product_id' => Product::inRandomOrder()->first()->id ?? Product::factory(),
            'order_id' => \App\Models\Order::inRandomOrder()->first()->id ?? \App\Models\Order::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'body' => $this->faker->paragraph(2),
            'status' => $status,
            'admin_note' => $status !== 'pending' ? $this->faker->sentence() : null,
            'approved_by' => $approvedBy,
            'approved_at' => $approvedAt,
        ];
    }
}
