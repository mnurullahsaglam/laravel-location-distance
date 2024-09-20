<?php

use App\Models\Location;
use App\Models\User;

test('locations.show page can be displayed', function () {
    $user = User::factory()->create();
    $location = Location::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/locations/' . $location->id);

    $response->assertOk();
});
