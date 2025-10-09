<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ProductVariantSize;
use Illuminate\Database\Seeder;

class ProductVariantSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductVariantSize::factory()->count(30)->create();
    }
}
