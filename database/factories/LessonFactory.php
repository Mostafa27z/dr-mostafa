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
            'title'          => fake('ar_SA')->realText(20),
            'description'    => fake('ar_SA')->realText(150),
            'video'          => $this->faker->regexify('[A-Za-z0-9_-]{11}'),
            'video_name'     => 'YouTube Video',
            'video_size'     => 0,
            'video_duration' => null,
            'files'          => [],
            'course_id'      => Course::factory(),
            'order'          => $this->faker->numberBetween(1, 10),
            'is_free'        => $this->faker->boolean(),
            'status'         => $this->faker->randomElement(['draft', 'active', 'inactive']),
            'published_at'   => now(),
        ];
    }
}
