<?php

use App\Models\Location;
use App\Models\User;

test('locations.edit page can be displayed', function () {
    $user = User::factory()->create();
    $location = Location::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/locations/' . $location->id . '/edit');

    $response->assertOk();
});

test('locations can be updated', function () {
    $user = User::factory()->create();
    $location = Location::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/locations/' . $location->id, [
            'name' => 'Updated Location',
            'latitude' => '87.654321',
            'longitude' => '123.456789',
            'marker_color' => '#ff0000',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/locations');

    $this->assertDatabaseHas('locations', [
        'id' => $location->id,
        'name' => 'Updated Location',
        'latitude' => '87.654321',
        'longitude' => '123.456789',
        'marker_color' => '#ff0000',
    ]);
});
