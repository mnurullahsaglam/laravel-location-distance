<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class LocationController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return LocationResource::collection(Cache::rememberForever('locations', function () {
            return Location::all();
        }));
    }

    public function store(LocationRequest $request): LocationResource
    {
        $location = Location::create($request->validated());

        return new LocationResource($location);
    }

    public function show(Location $location): LocationResource
    {
        return new LocationResource($location);
    }

    public function update(LocationRequest $request, Location $location): LocationResource
    {
        $location->update($request->validated());

        return new LocationResource($location);
    }

    public function destroy(Location $location): Response
    {
        $location->delete();

        return response()->noContent();
    }
}
