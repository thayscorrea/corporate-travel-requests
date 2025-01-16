<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\TravelOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user model creation.
     */
    public function test_user_creation()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);

        $this->assertEquals('Test User', $user->name);
    }

    /**
     * Test travel order model creation.
     */
    public function test_travel_order_creation()
    {
        $user = User::factory()->create();
        $travelOrder = TravelOrder::factory()->create([
            'user_id' => $user->id,
            'applicant_name' => 'John Doe',
            'destination' => 'New York',
            'departure_date' => now()->addDays(2)->toDateString(),
            'return_date' => now()->addDays(5)->toDateString(),
            'status' => 'solicitado',
        ]);

        $this->assertDatabaseHas('travel_orders', [
            'applicant_name' => 'John Doe',
            'destination' => 'New York',
        ]);

        $this->assertEquals('solicitado', $travelOrder->status);
    }

    /**
     * Test relationship between user and travel orders.
     */
    public function test_user_travel_order_relationship()
    {
        $user = User::factory()->create();
        $travelOrder = TravelOrder::factory()->create([
            'user_id' => $user->id,
            'applicant_name' => 'John Doe',
            'destination' => 'New York',
            'departure_date' => now()->addDays(2)->toDateString(),
            'return_date' => now()->addDays(5)->toDateString(),
            'status' => 'solicitado',
        ]);

        $this->assertEquals($user->id, $travelOrder->user->id);
    }

    /**
     * Test updating travel order status.
     */
    public function test_update_travel_order_status()
    {
        $travelOrder = TravelOrder::factory()->create(['status' => 'solicitado']);

        $travelOrder->update(['status' => 'aprovado']);

        $this->assertDatabaseHas('travel_orders', [
            'id' => $travelOrder->id,
            'status' => 'aprovado',
        ]);
    }
}
