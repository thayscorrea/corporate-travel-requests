<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TravelOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Criar usuários fictícios
        $users = User::factory(10)->create();

        // Criar pedidos de viagem para cada usuário
        foreach ($users as $user) {
            TravelOrder::factory(5)->create([
                'user_id' => $user->id,
            ]);

            // Inserir notificações fictícias
            DB::table('notifications')->insert([
                [
                    'id' => Str::uuid()->toString(),
                    'type' => 'aprovado',
                    'notifiable_id' => $user->id,
                    'notifiable_type' => User::class,
                    'data' => json_encode([
                        'message' => 'Your order has been approved.',
                        'type' => 'aprovado',
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => Str::uuid()->toString(),
                    'type' => 'cancelado',
                    'notifiable_id' => $user->id,
                    'notifiable_type' => User::class,
                    'data' => json_encode([
                        'message' => 'Your order has been canceled.',
                        'type' => 'cancelado',
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}