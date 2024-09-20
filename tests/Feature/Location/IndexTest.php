<?php

use App\Models\Location;
use App\Models\User;

test('locations list can be returned', function () {
    $user = User::factory()->create();
    $locations = Location::factory(3)->create();

    $response = $this
        ->actingAs($user)
        ->get('/api/v1/locations');

    $response->assertStatus(200);

    $locations->each(function ($location) use ($response) {
        $response->assertSee($location->name);
    });
});
