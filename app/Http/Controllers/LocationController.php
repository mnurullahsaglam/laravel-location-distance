<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function index(): View
    {
        $locations = Location::orderBy('name')->paginate();

        return view('locations.index', compact('locations'));
    }

    public function create(): View
    {
        return view('locations.create');
    }

    public function store(LocationRequest $request): RedirectResponse
    {
        Location::create($request->validated());

        return to_route('locations.index');
    }

    public function show(Location $location): View
    {
        return view('locations.show', compact('location'));
    }

    public function edit(Location $location): View
    {
        return view('locations.edit', compact('location'));
    }

    public function update(LocationRequest $request, Location $location): RedirectResponse
    {
        $location->update($request->validated());

        return to_route('locations.index');
    }

    public function destroy(Location $location): RedirectResponse
    {
        $location->delete();

        return to_route('locations.index');
    }
}
