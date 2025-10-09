<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Assignment;

class AssignmentAnswerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id' => User::factory(),
            'assignment_id' => Assignment::factory(),
            'answer_text' => $this->faker->sentence,
            'answer_file' => null,
            'teacher_comment' => null,
            'teacher_degree' => null,
            'teacher_file' => null,
        ];
    }
}
