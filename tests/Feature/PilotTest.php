<?php

namespace Tests\Feature;

use App\Models\Pilot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PilotTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_it_gets_pilots()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        Pilot::factory()->create();

        $response = $this->getJson(route('pilots.index'));

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'ship',
                    ]
                ]
            ]);
    }

    public function test_calling_pilots_gets_an_error_if_unauthenticated()
    {
        Pilot::factory()->create();

        $response = $this->getJson(route('pilots.index'));

        $response->assertUnauthorized();
    }

    public function test_it_gets_a_specific_pilot()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $pilot = Pilot::factory()->create();

        $response = $this->getJson(route('pilots.show', $pilot));

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'ship',
                ]
            ]);
    }

    public function test_calling_specific_pilot_gets_an_error_if_unauthenticated()
    {
        $pilot = Pilot::factory()->create();

        $response = $this->getJson(route('pilots.show', $pilot));

        $response
            ->assertUnauthorized();
    }

    public function test_it_creates_a_pilot_with_valid_fields()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $data = [
            'first_name' => 'Kevin',
            'last_name' => 'Alcantara',
            'age' => 18,
            'credits' => 150,
            'certification' => '1234567',
        ];

        $response = $this->postJson(route('pilots.store', $data));

        $response
            ->assertValid()
            ->assertCreated();
    }

    public function test_creating_pilot_gets_an_error_if_fields_are_invalid()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $data = [
            'first_name' => 'Kevin',
            'last_name' => 'Alcantara',
            'age' => 17,
            'credits' => 150,
            'certification' => 'lol',
        ];

        $response = $this->postJson(route('pilots.store', $data));

        $response
            ->assertInvalid(['age', 'certification'])
            ->assertUnprocessable();
    }

    public function test_creating_pilot_gets_an_error_if_unauthenticated()
    {
        $response = $this->postJson(route('pilots.store'), []);

        $response->assertUnauthorized();
    }

    public function test_it_updates_a_pilot_with_valid_fields()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $pilot = Pilot::factory()->create();

        $data = [
            'first_name' => 'Kevin',
            'age' => 18,
            'credits' => 150,
        ];

        $response = $this->putJson(route('pilots.update', $pilot), $data);

        $response
            ->assertValid()
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'ship',
                ]
            ]);
    }

    public function test_updating_a_pilot_gets_an_error_if_fields_are_invalid()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $pilot = Pilot::factory()->create();

        $data = [
            'first_name' => 'Kevin',
            'credits' => 'money',
            'certification' => 'lol',
        ];

        $response = $this->putJson(route('pilots.update', $pilot), $data);

        $response
            ->assertInvalid(['credits', 'certification'])
            ->assertUnprocessable();
    }

    public function test_updating_a_pilot_gets_an_error_if_unauthenticated()
    {
        $pilot = Pilot::factory()->create();

        $response = $this->putJson(route('pilots.update', $pilot), []);

        $response->assertUnauthorized();
    }

    public function test_it_deletes_a_pilot()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );

        $pilot = Pilot::factory()->create();

        $response = $this->deleteJson(route('pilots.destroy', $pilot));

        $response->assertNoContent();

        $this->assertSoftDeleted($pilot);
    }

    public function test_calling_pilot_gets_an_error_if_deleted()
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $pilot = Pilot::factory()->create();

        $pilot->delete();

        $response = $this->getJson(route('pilots.show', $pilot));

        $response->assertNotFound();
    }

    public function test_delete_pilot_gets_an_error_if_unauthenticated()
    {
        $pilot = Pilot::factory()->create();

        $response = $this->deleteJson(route('pilots.destroy', $pilot));

        $response->assertUnauthorized();
    }
}
