<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $products = Product::all();

        if ($categories->count() === 0) {
            $categories = Category::factory()->count(5)->create();
        }
        if ($products->count() === 0) {
            $products = Product::factory()->count(10)->create();
        }

        $products->each(function ($product) use ($categories) {
            $randomCategoryIds = $categories->random(rand(1, 3))->pluck('id')->toArray();
            $product->categories()->attach($randomCategoryIds);
        });
    }
}
