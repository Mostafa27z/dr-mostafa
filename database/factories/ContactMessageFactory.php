<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactMessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake('ar_SA')->name(),
            'phone' => fake('ar_SA')->phoneNumber(),
            'title' => fake('ar_SA')->realText(30),
            'content' => fake('ar_SA')->realText(200),
        ];
    }
}
