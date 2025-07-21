<?php

use App\Events\HabitReminderEvent;
use Illuminate\Support\Facades\Route;

Route::get('/test-broadcast', function () {
    event(new HabitReminderEvent(1, 'Test Habit'));
    return 'Broadcast Sent';
});

