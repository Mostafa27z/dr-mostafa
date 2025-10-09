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
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'files' => [],
            'deadline' => now()->addDays(3),
            'is_open' => false,
            'total_mark' => 100,
            'lesson_id' => Lesson::factory(),
            'group_id' => Group::factory(),
        ];
    }
}
