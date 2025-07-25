<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DataHabitController;
use App\Http\Controllers\Api\HabitCheckinController;
use App\Http\Controllers\Api\HabitController;
use App\Http\Controllers\Api\ReminderHabitController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/habits', HabitController::class)->except('show');
    Route::post('/habit/{id}/check', HabitCheckinController::class);
    Route::get('/streaks', [DataHabitController::class, 'streakHabit']);
    Route::apiResource('/reminder-habits', ReminderHabitController::class)->except('show');
});

Route::middleware('guest.jwt')->group(function(){
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});
