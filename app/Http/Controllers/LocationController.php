<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Models\Location;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::orderBy('name')->paginate();

        return view('locations.index', compact('locations'));
    }

    public function create()
    {
        return view('locations.create');
    }

    public function store(LocationRequest $request)
    {
        Location::create($request->validated());

        return to_route('locations.index');
    }

    public function show(Location $location)
    {
        return view('locations.show', compact('location'));
    }

    public function edit(Location $location)
    {
        return view('locations.edit', compact('location'));
    }

    public function update(LocationRequest $request, Location $location)
    {
        $location->update($request->validated());

        return to_route('locations.index');
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return to_route('locations.index');
    }
}
