<?php

use App\Models\Location;
use App\Models\User;

test('locations can be deleted', function () {
    $user = User::factory()->create();
    $location = Location::factory()->create();

    $response = $this
        ->actingAs($user)
        ->delete('/api/v1/locations/' . $location->id);

    $response->assertStatus(204);

    $this->assertNull(Location::find($location->id));
});
