<?php

use App\Models\Location;
use App\Models\User;

test('locations.index page can be displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/locations');

    $response->assertOk();
});

test('locations.index page contains locations', function () {
    $user = User::factory()->create();
    $locations = Location::factory()->count(3)->create();

    $response = $this
        ->actingAs($user)
        ->get('/locations');

    $response->assertSee($locations[0]->name);
    $response->assertSee($locations[1]->name);
    $response->assertSee($locations[2]->name);
});
