<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'text'       => fake()->text(1000),
            'created_at' => fake()->dateTimeBetween('-2 years', now()),
        ];
    }
}
