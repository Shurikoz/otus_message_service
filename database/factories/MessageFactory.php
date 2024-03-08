<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'text' => $this->faker->realTextBetween(50, 300),
            'user_id' => $this->faker->randomElement(User::all()->pluck('id')->toArray()),
            'channel_id' => $this->faker->randomElement(Channel::all()->pluck('id')->toArray()),
        ];
    }
}
