<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin ZeonGame',
            'email' => 'admin@zeongame.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'balance' => 0,
            'email_verified_at' => now(),
        ]);

        // Regular users for testing
        $users = [
            ['name' => 'Fajar Pranayoga', 'email' => 'fajar@test.com'],
            ['name' => 'Budi Santoso', 'email' => 'budi@test.com'],
            ['name' => 'Siti Nurhaliza', 'email' => 'siti@test.com'],
            ['name' => 'Ahmad Rizki', 'email' => 'ahmad@test.com'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi@test.com'],
            ['name' => 'Reza Aditya', 'email' => 'reza@test.com'],
            ['name' => 'Maya Putri', 'email' => 'maya@test.com'],
            ['name' => 'Andi Wijaya', 'email' => 'andi@test.com'],
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make('password'), // All use 'password'
                'is_admin' => false,
                'balance' => rand(10000, 500000),
                'email_verified_at' => now(),
            ]);
        }
    }
}
