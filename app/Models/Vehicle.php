<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = ['registration_number', 'make', 'model'];

    public function parkingSessions()
    {
        return $this->hasMany(ParkingSession::class);
    }
}