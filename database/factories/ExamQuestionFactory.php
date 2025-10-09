<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Exam;

class ExamQuestionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'exam_id' => Exam::factory(),
            'title' => $this->faker->sentence(),
            'degree' => $this->faker->numberBetween(1, 10),
        ];
    }
}
