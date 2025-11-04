<?php

namespace Database\Factories;

use App\Enums\MailType;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Mail;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mail>
 */
class MailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Mail::class;

    public function definition(): array
    {
        return [
            'created_by' => User::inRandomOrder()->first()?->id ?? 1,
            'name' => $this->faker->unique()->word(),
            'title' => $this->faker->sentence(6),
            'body' => $this->faker->paragraphs(3, true),
            'variables' => (object)[
                'username' => $this->faker->userName(),
                'order_id' => $this->faker->uuid(),
                'tracking_code' => strtoupper($this->faker->bothify('TRK###??')),
            ],
            'type' =>  $this->faker->randomElement(MailType::cases()),
            // 30% có lịch gửi, còn lại gửi ngay
            'scheduled_at' => $this->faker->optional(0.3)->dateTimeBetween('now', '+3 days'),
        ];
    }
}
