<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryBlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $blogs = Blog::all();

        if ($categories->count() === 0) {
            $categories = Category::factory()->count(5)->create();
        }
        if ($blogs->count() === 0) {
            $blogs = Blog::factory()->count(10)->create();
        }

        $blogs->each(function ($blog) use ($categories) {
            $randomCategoryIds = $categories->random(rand(1, 3))->pluck('id')->toArray();
            $blog->categories()->attach($randomCategoryIds);
        });
    }
}
