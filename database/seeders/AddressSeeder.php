<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            // Tạo số lượng địa chỉ ngẫu nhiên (ví dụ: 2–4)
            $addressCount = rand(2, 4);

            for ($i = 0; $i < $addressCount; $i++) {
                Address::create([
                    'user_id' => $user->id,
                    'recipient_name' => fake()->name(),
                    'recipient_phone' => fake()->phoneNumber(),
                    'province' => fake()->state(),
                    'district' => fake()->city(),
                    'ward' => fake()->streetName(),
                    'detailed_address' => fake()->address(),
                    'is_default' => $i === 0,
                ]);
            }
        }
    }
}
