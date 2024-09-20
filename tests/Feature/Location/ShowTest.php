<?php

use App\Models\Location;
use App\Models\User;

test('locations can be displayed', function () {
    $user = User::factory()->create();
    $location = Location::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/api/v1/locations/' . $location->id);

    $response->assertStatus(200);
});
