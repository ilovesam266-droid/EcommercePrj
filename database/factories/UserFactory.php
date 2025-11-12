<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $filename = 'avatars/' . uniqid() . '.jpg';
        $imageContent = Http::get('https://i.pravatar.cc/150')->body();
        Storage::disk('public')->put($filename, $imageContent);
        $first_name = fake()->firstName();
        $last_name = fake()->lastName();
        $username = Str::lower($first_name . '.' . $last_name . fake()->randomNumber());
        return [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'username' => $username,
            'birthday' => fake()->optional()->date('Y-m-d', '-20 years'),
            'avatar' => $filename,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => fake()->randomElement(['admin', 'user']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
