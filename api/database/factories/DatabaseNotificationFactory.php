<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Str;
use App\Models\User;

class DatabaseNotificationFactory extends Factory
{
    protected $model = DatabaseNotification::class;

    public function definition()
    {
        return [
            'id' => Str::uuid()->toString(), // UUID gerado automaticamente
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(['aprovado', 'cancelado']),
            'message' => $this->faker->sentence,
            'created_at' => null, // Será definido no teste
            'updated_at' => null, // Pode ser `now()` para notificação lida
        ];
    }
}
