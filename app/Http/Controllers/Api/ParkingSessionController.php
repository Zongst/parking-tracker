<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParkingSessionController extends Controller
{
    public function index(Request $request)
    {
        $query = ParkingSession::with('vehicle');

        if ($search = $request->query('search')) {
            $query->whereHas('vehicle', fn($q) =>
                $q->where('registration_number', 'like', "%$search%")
                  ->orWhere('make', 'like', "%$search%")
                  ->orWhere('model', 'like', "%$search%")
            );
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($sort = $request->query('sort')) {
            [$column, $direction] = explode(':', $sort) + [null, 'asc'];
            $query->orderBy($column ?? 'entry_time', $direction);
        }

        return response()->json($query->paginate(10));
    }

    public function show($id)
    {
        return ParkingSession::with('vehicle')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'entry_time' => 'required|date',
            'exit_time' => 'nullable|date|after:entry_time',
        ]);

        $data = $validated;
        if (!empty($data['exit_time'])) {
            $data['duration_minutes'] = (new DateTime($data['entry_time']))
                ->diff(new DateTime($data['exit_time']))
                ->i + (new DateTime($data['entry_time']))->diff(new DateTime($data['exit_time']))->h * 60;
            $data['status'] = 'completed';
        }

        $session = ParkingSession::create($data);
        return response()->json($session, 201);
    }
}