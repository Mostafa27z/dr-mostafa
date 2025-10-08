<?php

namespace Database\Factories;

use App\Models\CourseEnrollment;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseEnrollment>
 */
class CourseEnrollmentFactory extends Factory
{
    protected $model = CourseEnrollment::class;

    public function definition(): array
    {
        return [
            'course_id'      => Course::factory(), // automatically create a course
            'student_id'     => User::factory()->create(['role' => 'student'])->id,
            'status'         => $this->faker->randomElement(['pending', 'approved', 'completed', 'rejected']),
            'enrolled_at'    => now()->subDays(rand(1, 10)),
            'completed_at'   => $this->faker->boolean(30) ? now() : null,
            'paid_amount'    => $this->faker->randomFloat(2, 50, 500),
            'payment_method' => $this->faker->randomElement(['credit_card', 'paypal', 'bank_transfer']),
            'transaction_id' => strtoupper($this->faker->bothify('TXN###??')),
            'notes'          => $this->faker->optional()->sentence(),
        ];
    }

    /**
     * Indicate that the enrollment is approved.
     */
    public function approved(): static
    {
        return $this->state(fn() => [
            'status' => 'approved',
            'enrolled_at' => now(),
        ]);
    }

    /**
     * Indicate that the enrollment is completed.
     */
    public function completed(): static
    {
        return $this->state(fn() => [
            'status' => 'completed',
            'enrolled_at' => now()->subDays(5),
            'completed_at' => now(),
        ]);
    }
}
