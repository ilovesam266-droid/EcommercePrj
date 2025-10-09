<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VariantSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = [
            ['name' => 'XS', 'size' => 35],
            ['name' => 'S', 'size' => 36],
            ['name' => 'M', 'size' => 37],
            ['name' => 'L', 'size' => 38],
            ['name' => 'XL', 'size' => 39],
            ['name' => 'XXL', 'size' => 40],
        ];

        foreach ($sizes as $s) {
            $s['created_by'] = User::inRandomOrder()->first()?->id ?? 1;
            VariantSize::create($s);
        }
    }
}
