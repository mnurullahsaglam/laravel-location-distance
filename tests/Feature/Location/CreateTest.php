<?php

use App\Models\Location;
use App\Models\User;

test('locations.create page can be displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/locations/create');

    $response->assertOk();
});

test('locations can be created', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/locations', [
            'name' => 'Test Location',
            'latitude' => '87.654321',
            'longitude' => '123.456789',
            'marker_color' => '#ff0000',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/locations');

    $this->assertDatabaseHas('locations', [
        'name' => 'Test Location',
        'latitude' => '87.654321',
        'longitude' => '123.456789',
        'marker_color' => '#ff0000',
    ]);
});

test('locations required fields', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/locations', []);

    $response->assertSessionHasErrors([
        'name' => 'The name field is required.',
        'latitude' => 'The latitude field is required.',
        'longitude' => 'The longitude field is required.',
        'marker_color' => 'The marker color field is required.',
    ]);
});

test('name field must be unique', function () {
    $user = User::factory()->create();
    $location = Location::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/locations', [
            'name' => $location->name,
            'latitude' => '87.654321',
            'longitude' => '123.456789',
            'marker_color' => '#ff0000',
        ]);

    $response->assertSessionHasErrors([
        'name' => 'The name has already been taken.',
    ]);
});

test('locations name field min length validation', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/locations', [
            'name' => str_repeat('a', 1),
            'latitude' => '87.654321',
            'longitude' => '123.456789',
            'marker_color' => '#ff0000',
        ]);

    $response->assertSessionHasErrors([
        'name' => 'The name field must be at least 3 characters.',
    ]);
});

test('locations name field max length validation', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/locations', [
            'name' => str_repeat('a', 256),
            'latitude' => '87.654321',
            'longitude' => '123.456789',
            'marker_color' => '#ff0000',
        ]);

    $response->assertSessionHasErrors([
        'name' => 'The name field must not be greater than 255 characters.',
    ]);
});

test('location latitude field min value validation', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/locations', [
            'name' => 'Test Location',
            'latitude' => '-90.000001',
            'longitude' => '123.456789',
            'marker_color' => '#ff0000',
        ]);

    $response->assertSessionHasErrors([
        'latitude' => 'The latitude field must be at least -90.',
    ]);
});

test('location latitude field max value validation', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/locations', [
            'name' => 'Test Location',
            'latitude' => '90.000001',
            'longitude' => '123.456789',
            'marker_color' => '#ff0000',
        ]);

    $response->assertSessionHasErrors([
        'latitude' => 'The latitude field must not be greater than 90.',
    ]);
});

test('location longitude field min value validation', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/locations', [
            'name' => 'Test Location',
            'latitude' => '-90.00000',
            'longitude' => '-180.000001',
            'marker_color' => '#ff0000',
        ]);

    $response->assertSessionHasErrors([
        'longitude' => 'The longitude field must be at least -180.',
    ]);
});

test('location longitude field max value validation', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/locations', [
            'name' => 'Test Location',
            'latitude' => '90.00000',
            'longitude' => '180.000001',
            'marker_color' => '#ff0000',
        ]);

    $response->assertSessionHasErrors([
        'longitude' => 'The longitude field must not be greater than 180.',
    ]);
});

test('marker color must be hex color', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->post('/locations', [
            'name' => 'Test Location',
            'latitude' => '87.654321',
            'longitude' => '123.456789',
            'marker_color' => 'not-a-hex-color',
        ]);

    $response->assertSessionHasErrors([
        'marker_color' => 'The marker color field must be a valid hexadecimal color.',
    ]);
});
