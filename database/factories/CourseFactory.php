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
            'title' => fake('ar_SA')->realText(20),
            'description' => fake('ar_SA')->realText(200),
            'image' => null,
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'teacher_id' => User::factory()->teacher(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
