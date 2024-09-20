<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CoordinateRequest;
use App\Models\Location;
use Illuminate\Support\Facades\Cache;

class RouteController extends Controller
{
    public function store(CoordinateRequest $request)
    {
        $latitudeFrom = $request->latitude;
        $longitudeFrom = $request->longitude;

        $locations = Cache::get('locations', function () {
            return Location::all();
        });

        $locationIds = $locations->pluck('id')->toArray();
        $allRoutes = $this->getPermutations($locationIds);

        $shortestDistance = PHP_INT_MAX;
        $shortestRoute = null;
        $shortestRouteSteps = [];

        foreach ($allRoutes as $route) {
            $totalDistance = 0;
            $previousLatitude = $latitudeFrom;
            $previousLongitude = $longitudeFrom;
            $routeSteps = [];

            foreach ($route as $locationId) {
                $location = $locations->find($locationId);

                $stepDistance = $this->haversineGreatCircleDistance(
                    $previousLatitude, $previousLongitude,
                    $location->latitude, $location->longitude
                );

                $totalDistance += $stepDistance;

                $routeSteps[] = [
                    'from_latitude' => $previousLatitude,
                    'from_longitude' => $previousLongitude,
                    'to_latitude' => $location->latitude,
                    'to_longitude' => $location->longitude,
                    'step_distance_km' => $stepDistance,
                ];

                $previousLatitude = $location->latitude;
                $previousLongitude = $location->longitude;
            }

            $returnDistance = $this->haversineGreatCircleDistance(
                $previousLatitude, $previousLongitude,
                $latitudeFrom, $longitudeFrom
            );

            $totalDistance += $returnDistance;
            $routeSteps[] = [
                'from_latitude' => $previousLatitude,
                'from_longitude' => $previousLongitude,
                'to_latitude' => $latitudeFrom,
                'to_longitude' => $longitudeFrom,
                'step_distance_km' => $returnDistance,
            ];

            if ($totalDistance < $shortestDistance) {
                $shortestDistance = $totalDistance;
                $shortestRoute = $route;
                $shortestRouteSteps = $routeSteps;
            }
        }

        return response()->json([
            'shortest_route' => $shortestRoute,
            'shortest_distance_km' => number_format($shortestDistance, 2),
            'route_steps' => $shortestRouteSteps,
        ]);
    }

    private function getPermutations($items, $perms = [])
    {
        if (empty($items)) {
            return [$perms];
        } else {
            $result = [];
            for ($i = 0; $i < count($items); $i++) {
                $newItems = $items;
                $newPerms = $perms;
                array_splice($newItems, $i, 1);
                $newPerms[] = $items[$i];
                $result = array_merge($result, $this->getPermutations($newItems, $newPerms));
            }

            return $result;
        }
    }

    private function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
    {
        $latitudeFrom = deg2rad($latitudeFrom);
        $longitudeFrom = deg2rad($longitudeFrom);
        $latitudeTo = deg2rad($latitudeTo);
        $longitudeTo = deg2rad($longitudeTo);

        $latDiff = $latitudeTo - $latitudeFrom;
        $lonDiff = $longitudeTo - $longitudeFrom;

        $a = sin($latDiff / 2) * sin($latDiff / 2) +
            cos($latitudeFrom) * cos($latitudeTo) *
            sin($lonDiff / 2) * sin($lonDiff / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
