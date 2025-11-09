<?php

use App\Http\Controllers\ParkingSessionController;
use App\Http\Controllers\VehicleController;

Route::get('/vehicles', [VehicleController::class, 'index']);
Route::post('/vehicles', [VehicleController::class, 'store']);
Route::get('/sessions', [ParkingSessionController::class, 'index']);
Route::get('/sessions/{id}', [ParkingSessionController::class, 'show']);
Route::post('/sessions', [ParkingSessionController::class, 'store']);
