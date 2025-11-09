<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkingSession;
use DateTime;   
use Carbon\Carbon;

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
            $direction = $request->query('direction') ?? 'asc';
            $query->orderBy($sort ?? 'entry_time', $direction);
        }
        $query->paginate(10);

        return response()->json($query->paginate(10));
    }

    public function show($id)
    {
        return ParkingSession::with('vehicle')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'entry_time' => 'required|date',
            'exit_time' => 'nullable|date|after:entry_time',
        ]);

        $duration = null;
        $entry = Carbon::parse($data['entry_time']);

        if(empty($data['exit_time'])) {
            $exit = null;
        }else{
            $exit  = Carbon::parse($data['exit_time']);
            $duration = $entry->diffInMinutes($exit);
        }


        $session = ParkingSession::create([
            'vehicle_id'       => $data['vehicle_id'],
            'entry_time'       => $entry,
            'exit_time'        => $exit,
            'duration_minutes' => $duration,
            'status'           => $exit ? 'completed' : 'active',
        ]);
        

        return response()->json($session, 201);
    }
}