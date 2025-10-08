<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    protected $model = Exam::class;

    public function definition(): array
    {
        return [
            'title'         => $this->faker->sentence(3),
            'description'   => $this->faker->paragraph(),
            'start_time'    => now()->addDays(rand(1, 3)),
            'end_time'      => now()->addDays(rand(4, 6)),
            'duration'      => $this->faker->numberBetween(30, 120),
            'is_open'       => $this->faker->boolean(),
            'is_limited'    => $this->faker->boolean(),
            'total_degree'  => $this->faker->numberBetween(50, 100),
            'lesson_id'     => Lesson::factory(), 
            'teacher_id'    => User::factory()->create(['role' => 'teacher'])->id,
            'group_id'      => null, // optional
            'created_at'    => now(),
            'updated_at'    => now(),
        ];
    }
}
