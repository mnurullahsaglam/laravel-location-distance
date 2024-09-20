<?php

use App\Models\Location;
use App\Models\User;

test('locations can be deleted', function () {
    $user = User::factory()->create();
    $location = Location::factory()->create();

    $response = $this
        ->actingAs($user)
        ->delete('/locations/' . $location->id);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/locations');

    $this->assertNull(Location::find($location->id));
});
