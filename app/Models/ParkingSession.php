<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParkingSession extends Model
{
    use HasFactory;
    protected $fillable = ['vehicle_id', 'entry_time', 'exit_time', 'duration_minutes', 'status'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}