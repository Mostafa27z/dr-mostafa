<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'image' => null,
            'price' => $this->faker->randomFloat(2, 0, 500),
            'teacher_id' => User::factory(), // يربط جروب بمعلم جديد
        ];
    }
}
