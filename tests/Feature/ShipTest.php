<?php

namespace Tests\Feature;

use App\Models\Pilot;
use App\Models\Ship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ShipTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_it_gets_ships()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        Ship::factory()->create();

        $response = $this->getJson(route('ships.index'));

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'pilot',
                    ]
                ]
            ]);
    }

    public function test_calling_ships_gets_an_error_if_unauthenticated()
    {
        Ship::factory()->create();

        $response = $this->getJson(route('ships.index'));

        $response->assertUnauthorized();
    }

    public function test_it_gets_a_specific_ship()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $ship = Ship::factory()->create();

        $response = $this->getJson(route('ships.show', $ship));

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'pilot',
                ]
            ]);
    }

    public function test_calling_specific_ship_gets_an_error_if_unauthenticated()
    {
        $ship = Ship::factory()->create();

        $response = $this->getJson(route('ships.show', $ship));

        $response
            ->assertUnauthorized();
    }

    public function test_it_creates_a_ship_with_valid_fields()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $pilot = Pilot::factory()->create();

        $data = [
            'pilot_id' => $pilot->id,
            'fuel_capacity' => 500,
            'fuel_level' => 50,
            'weight_capacity' => 250,
        ];

        $response = $this->postJson(route('ships.store', $data));

        $response
            ->assertValid()
            ->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'pilot',
                ]
            ]);
    }

    public function test_creating_ship_gets_an_error_if_fields_are_invalid()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $data = [
            'fuel_capacity' => 500,
            'fuel_level' => 50,
            'weight_capacity' => 250,
        ];

        $response = $this->postJson(route('ships.store', $data));

        $response
            ->assertInvalid(['pilot_id'])
            ->assertUnprocessable();
    }

    public function test_creating_ship_gets_an_error_if_unauthenticated()
    {
        $response = $this->postJson(route('ships.store'), []);

        $response->assertUnauthorized();
    }

    public function test_it_updates_a_ship_with_valid_fields()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $ship = Ship::factory()->create();

        $pilot = Pilot::factory()->create();

        $data = [
            'pilot_id' => $pilot->id,
            'fuel_level' => 50,
        ];

        $response = $this->putJson(route('ships.update', $ship), $data);

        $response
            ->assertValid()
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'pilot',
                ]
            ]);
    }

    public function test_updating_a_ship_gets_an_error_if_fields_are_invalid()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $ship = Ship::factory()->create();

        $data = [
            'pilot_id' => 666,
            'fuel_level' => 'lol',
        ];

        $response = $this->putJson(route('ships.update', $ship), $data);

        $response
            ->assertInvalid(['pilot_id', 'fuel_level'])
            ->assertUnprocessable();
    }

    public function test_updating_a_ship_gets_an_error_if_unauthenticated()
    {
        $ship = Ship::factory()->create();

        $response = $this->putJson(route('ships.update', $ship), []);

        $response->assertUnauthorized();
    }

    public function test_it_deletes_a_ship()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $ship = Ship::factory()->create();

        $response = $this->deleteJson(route('ships.destroy', $ship));

        $response->assertNoContent();

        $this->assertSoftDeleted($ship);
    }

    public function test_calling_ship_gets_an_error_if_deleted()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $ship = Ship::factory()->create();

        $ship->delete();

        $response = $this->getJson(route('ships.show', $ship));

        $response->assertNotFound();
    }

    public function test_delete_ship_gets_an_error_if_unauthenticated()
    {
        $ship = Ship::factory()->create();

        $response = $this->deleteJson(route('ships.destroy', $ship));

        $response->assertUnauthorized();
    }
}
