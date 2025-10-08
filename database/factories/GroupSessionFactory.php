<?php

namespace Database\Factories;

use App\Models\GroupSession;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class GroupSessionFactory extends Factory
{
    protected $model = GroupSession::class;

    public function definition(): array
    {
        $startTime = Carbon::now()->addDays(rand(1, 10))->setTime(rand(8, 20), 0, 0);

        return [
            'group_id' => Group::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'time' => $startTime,
            'link' => $this->faker->url(),
        ];
    }
}
