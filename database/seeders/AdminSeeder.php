<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@loan.com',
            'mobile' => '1234567890',
            'password' => 'admin123',
            'role' => UserRole::Admin->value,
        ]);
    }
}
