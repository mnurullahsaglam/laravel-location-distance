<?php

use App\Http\Controllers\Api\V1\RouteController;

it('calculates the correct distance between two points', function ($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $expectedDistance) {
    $routeController = new RouteController();

    $calculatedDistance = $routeController->haversineGreatCircleDistance(
        $latitudeFrom,
        $longitudeFrom,
        $latitudeTo,
        $longitudeTo
    );

    $tolerance = 5;

    expect($calculatedDistance)->toBeGreaterThanOrEqual($expectedDistance - $tolerance)
        ->toBeLessThanOrEqual($expectedDistance + $tolerance);
})->with([
    [51.5074, -0.1278, 48.8566, 2.3522, 344], // ~344 km
    [-33.8688, 151.2093, -37.8136, 144.9631, 713], // ~713 km
    [37.7749, -122.4194, 37.8044, -122.2711, 13], // ~13 km
]);
