<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function index()
    {
       return response()->json(Vehicle::orderBy('registration_number')->paginate(10));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_number' => 'required|string|max:20|unique:vehicles,registration_number',
            'make' => 'required|string|max:50',
            'model' => 'required|string|max:50',
        ]);
        dd($validated);

        $session = Vehicle::create($validated);
        dd($vehicle);

        // Return a JSON response with 201 (Created)
        return response()->json($session, 201);
    }
    
}