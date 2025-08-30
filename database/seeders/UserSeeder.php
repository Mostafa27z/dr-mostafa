<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Teacher
        User::updateOrCreate(
            ['email' => 'teacher@example.com'],
            [
                'name' => 'Dr. Mostafa',
                'password' => Hash::make('password123'),
                'role' => 'teacher'
            ]
        );

        // Create Student
        User::updateOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Test Student',
                'password' => Hash::make('password123'),
                'role' => 'student'
            ]
        );
    }
}