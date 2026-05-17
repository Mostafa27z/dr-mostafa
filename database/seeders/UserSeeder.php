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
        // Create Default Admin
        User::updateOrCreate(
            ['email' => 'admin@mostafa.com'],
            [
                'name' => 'مدير النظام',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ]
        );

        // Create Default Teacher
        User::updateOrCreate(
            ['email' => 'teacher@mostafa.com'],
            [
                'name' => 'الأستاذ الدكتور أحمد علي',
                'password' => Hash::make('password'),
                'role' => 'teacher'
            ]
        );

        // Create Default Student
        User::updateOrCreate(
            ['email' => 'student@mostafa.com'],
            [
                'name' => 'محمد محمود',
                'password' => Hash::make('password'),
                'role' => 'student'
            ]
        );

        // Create more teachers
        $teachers = User::factory(5)->teacher()->create();

        // Create subscriptions for teachers
        foreach (User::where('role', 'teacher')->get() as $teacher) {
            \App\Models\Subscription::create([
                'user_id' => $teacher->id,
                'plan_name' => 'Standard',
                'starts_at' => now()->subDays(rand(1, 30)),
                'ends_at' => now()->addDays(rand(1, 60)),
                'status' => 'active',
                'price' => 500.00
            ]);
        }

        // Create more students
        User::factory(20)->student()->create();
    }
}