<?php

use App\Service\ReminderHabit;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::call(function () {
    Log::info("Scheduler dipanggil pada " . now());
    broadcast(new ReminderHabit());
})->everyMinute();

