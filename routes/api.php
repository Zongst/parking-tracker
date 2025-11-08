<?php

use App\Http\Controllers\Api\ParkingSessionController;
use App\Http\Controllers\Api\VehicleController;

Route::get('/vehicles', [VehicleController::class, 'index']);
Route::get('/sessions', [ParkingSessionController::class, 'index']);
Route::get('/sessions/{id}', [ParkingSessionController::class, 'show']);
Route::post('/sessions', [ParkingSessionController::class, 'store']);