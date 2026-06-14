<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkirVehicleType;

class VehicleTypeController extends Controller
{
    public function index()
    {
        $vehicleTypes = ParkirVehicleType::all();
        return view('vehicletype.index', compact('vehicleTypes'));
    }

    public function create()
    {
        return view('vehicletype.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:motorcycle,car,other',
            'perjam_pertama' => 'required|integer',
            'perjam_berikutnya' => 'required|integer',
            'max_perhari' => 'required|integer',
        ]);

        ParkirVehicleType::create($request->all());

        return redirect()->route('vehicletype.index')->with('success', 'Vehicle Type saved!');
    }
}