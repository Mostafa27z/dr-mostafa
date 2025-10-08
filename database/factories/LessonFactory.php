<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    protected $model = Lesson::class;

    public function definition(): array
    {
        return [
            'title'          => $this->faker->sentence(3),
            'description'    => $this->faker->paragraph(),
            'video'          => null,
            'video_name'     => null,
            'video_size'     => null,
            'video_duration' => null,
            'files'          => [],
            'course_id'      => Course::factory(), // linked course with teacher
            'order'          => $this->faker->numberBetween(1, 10),
            'is_free'        => $this->faker->boolean(),
            'status'         => $this->faker->randomElement(['draft', 'active', 'inactive']), // ✅ fixed
            'published_at'   => now(),
        ];
    }
}
