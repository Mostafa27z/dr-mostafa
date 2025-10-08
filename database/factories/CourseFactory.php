<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'image' => null,
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'teacher_id' => User::factory()->create(['role' => 'teacher'])->id, // ✅ ensure teacher is a user
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
