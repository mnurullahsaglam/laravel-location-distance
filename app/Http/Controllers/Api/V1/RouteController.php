<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CoordinateRequest;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use Illuminate\Support\Facades\Cache;

class RouteController extends Controller
{
    public function store(CoordinateRequest $request)
    {
        $locations = Cache::get('locations', function () {
            return Location::all();
        });

        $locations = $locations->map(function ($location) use ($request) {
            $location->distance = $location->calculateDistance($request->latitude, $request->longitude);

            return $location;
        });

        $sortedLocations = $locations->sortBy('distance')->values(); // Reset array keys

        return LocationResource::collection($sortedLocations);
    }
}
