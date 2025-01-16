<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class TravelOrderFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'applicant_name' => $this->faker->name,
            'destination' => $this->faker->city,
            'departure_date' => $this->faker->dateTimeBetween('now', '+1 week'),
            'return_date' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'status' => 'solicitado',
        ];
    }
}
