<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'username' => 'admin',
            'full_name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '01234567890',
        ]);

        // Create pharmacist user
        User::create([
            'username' => 'pharmacist',
            'full_name' => 'Staff Pharmacist',
            'email' => 'pharmacist@example.com',
            'password' => Hash::make('password'),
            'role' => 'pharmacist',
            'phone' => '01234567891',
        ]);

        // Create cashier user
        User::create([
            'username' => 'cashier',
            'full_name' => 'Staff Cashier',
            'email' => 'cashier@example.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
            'phone' => '01234567892',
        ]);
    }
}
