<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call([
        //     UserSeeder::class,
        //     CategorySeeder::class,
        //     ProductSeeder::class,
        //     ProductVariantSizeSeeder::class,
        //     OrderSeeder::class,
        // ]);
        $categories = Category::factory()->count(5)->create();
        $images = Image::factory()->count(20)->create();

        Product::factory()
        ->count(10)
        ->hasAttached($categories->random(2)) // attach 2 category ngẫu nhiên
        ->create()
        ->each(function ($product) use ($images) {
            // attach 3 ảnh ngẫu nhiên
            $product->images()->attach(
                $images->random(3)->pluck('id'),
                [
                    'is_primary' => false,
                    'order_of_images' => fake()->numberBetween(1, 5),
                ]
            );
        });
    }
}
