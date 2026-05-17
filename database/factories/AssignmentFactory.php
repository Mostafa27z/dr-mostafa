<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Lesson;
use App\Models\Group;

class AssignmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake('ar_SA')->realText(30),
            'description' => fake('ar_SA')->realText(150),
            'files' => [],
            'deadline' => now()->addDays(3),
            'is_open' => false,
            'total_mark' => 100,
            'lesson_id' => Lesson::factory(),
            'group_id' => Group::factory(),
        ];
    }
}
