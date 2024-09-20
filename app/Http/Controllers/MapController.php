<?php

namespace App\Http\Controllers;

use App\Models\Location;

class MapController extends Controller
{
    public function index()
    {
        $locations = Location::all();

        return view('map', compact('locations'));
    }
}
