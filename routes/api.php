<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HabitCheckinController;
use App\Http\Controllers\Api\HabitController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/habits', HabitController::class);
    Route::post('/habit/{id}/check', HabitCheckinController::class);

});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
