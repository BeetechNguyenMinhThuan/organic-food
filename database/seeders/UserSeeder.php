<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->create([
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$SLzpxEqMwU5h58daxM.QsOC.ZAdfOyA3tjkPkzZkUw/5TxyyB3J.q', // password
            'remember_token' => Str::random(10),
        ]);
        $user->assignRole('vip','normal');
    }
}
