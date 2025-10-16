<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Enums\UserRole;
use App\Enums\UserStatus;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
    //     User::create([
    //     'first_name' => 'Huy',
    //     'last_name' => 'Mai',
    //     'username' => 'huy',
    //     'email' => 'admin@email.com',
    //     'password' => Hash::make('12345'),
    //     'birthday' => fake()->date('Y-m-d','-20 years'),
    //     'avatar'     => "https://i.pravatar.cc/150?u={huy}",
    //     'role' => UserRole::ADMIN,
    //     'status' => UserStatus::ACTIVE,
    // ]);
        User::factory()->count(10)->create();
    }
}
