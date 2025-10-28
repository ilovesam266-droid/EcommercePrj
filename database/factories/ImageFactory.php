<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $filename = 'products/' . uniqid() . '.jpg';
        $name = $this->faker->unique()->words(3, true);

    // Tải ảnh ngẫu nhiên từ Lorem Picsum
    $imageContent = Http::get('https://picsum.photos/300/300')->body();

    // Lưu ảnh vào storage
    Storage::disk('public')->put($filename, $imageContent);

    return [
        'created_by' => User::inRandomOrder()->first()?->id ?? 1,
        'url' => $filename,
        'name' => ucfirst($name),
    ];
    }
}
