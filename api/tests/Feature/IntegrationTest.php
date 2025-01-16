<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\TravelOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Str;

class IntegrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user registration and login.
     */
    public function test_user_can_register_and_login()
    {
        // Register a new user
        $registerResponse = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $registerResponse->assertStatus(201)
            ->assertJsonStructure(['user' => ['id', 'name', 'email'], 'token']);

        // Log in with the new user
        $loginResponse = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $loginResponse->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    /**
     * Test creating and fetching travel orders.
     */
    public function test_user_can_create_and_fetch_travel_orders()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        // Create a travel order
        $createResponse = $this->postJson('/api/travel-orders', [
            'applicant_name' => 'John Doe',
            'destination' => 'New York',
            'departure_date' => now()->addDays(2)->toDateString(),
            'return_date' => now()->addDays(5)->toDateString(),
        ]);

        $createResponse->assertStatus(201)
            ->assertJsonStructure(['id', 'applicant_name', 'destination', 'departure_date', 'return_date', 'status']);

        // Fetch all travel orders
        $fetchResponse = $this->getJson('/api/travel-orders');

        $fetchResponse->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonFragment(['destination' => 'New York']);
    }

    /**
     * Test updating a travel order's status.
     */
    public function test_user_can_update_travel_order_status()
    {
        $user = User::factory()->create();
        $travelOrder = TravelOrder::factory()->create(['user_id' => $user->id, 'status' => 'solicitado']);

        $this->actingAs($user, 'sanctum');

        // Update the travel order status
        $updateResponse = $this->patchJson("/api/travel-orders/{$travelOrder->id}/status", [
            'status' => 'aprovado',
        ]);

        $updateResponse->assertStatus(200)
            ->assertJsonFragment(['status' => 'aprovado']);

        $this->assertDatabaseHas('travel_orders', [
            'id' => $travelOrder->id,
            'status' => 'aprovado',
        ]);
    }

    /**
     * Test deleting a travel order.
     */
    public function test_user_can_delete_travel_order()
    {
        $user = User::factory()->create();
        $travelOrder = TravelOrder::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user, 'sanctum');

        // Delete the travel order
        $deleteResponse = $this->deleteJson("/api/travel-orders/{$travelOrder->id}");

        $deleteResponse->assertStatus(200)
            ->assertJsonFragment(['message' => 'Order deleted successfully']);

        $this->assertDatabaseMissing('travel_orders', [
            'id' => $travelOrder->id,
        ]);
    }

    /**
     * Test fetching notifications.
     */
    public function test_user_can_fetch_notifications()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        // Inserir notificação diretamente no banco
        \DB::table('notifications')->insert([
            'id' => Str::uuid()->toString(), // Gerar UUID para o campo id
            'type' => 'aprovado',
            'notifiable_id' => $user->id,
            'notifiable_type' => \App\Models\User::class,
            'data' => json_encode(['message' => 'Your order is approved', 'type' => 'aprovado']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Buscar notificações
        $fetchResponse = $this->getJson('/api/notifications');

        $fetchResponse->assertStatus(200)
            ->assertJsonFragment(['message' => 'Your order is approved']);
    }
}
