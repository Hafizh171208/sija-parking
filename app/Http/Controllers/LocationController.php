<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkirLocation;

class LocationController extends Controller
{
    public function index()
    {
        $locations = ParkirLocation::all();
        return view('location.index', compact('locations'));
    }

    public function create()
    {
        return view('location.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'location_name' => 'required|string|max:100',
            'max_motorcycle' => 'required|integer',
            'max_car' => 'required|integer',
            'max_other' => 'required|integer',
        ]);

        ParkirLocation::create($request->except('_token'));

        return redirect()->route('location.index')->with('success', 'New Location was successfully saved!');
    }
}