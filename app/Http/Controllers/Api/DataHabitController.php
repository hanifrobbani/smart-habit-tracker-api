<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\HabitCheckins;
use Illuminate\Http\Request;

class DataHabitController extends Controller
{
    public function streakHabit()
    {
        $data = HabitCheckins::with('habit:id,name')
            ->select('habit_id', 'checkin_date')
            ->distinct()
            ->orderBy('habit_id')
            ->orderBy('checkin_date')
            ->get();

        $grouped = $data->groupBy('habit_id');
        $streaks = [];

        foreach ($grouped as $habitId => $records) {
            $dates = $records->pluck('checkin_date')
                ->map(fn($date) => Carbon::parse($date)->startOfDay())
                ->unique()
                ->sort()
                ->values();

            $currentStreak = 1;
            $maxStreak = 1;

            for ($i = 1; $i < $dates->count(); $i++) {
                $prev = $dates[$i - 1];
                $current = $dates[$i];

                if ($prev->copy()->addDay()->eq($current)) {
                    $currentStreak++;
                    $maxStreak = max($maxStreak, $currentStreak);
                } else {
                    $currentStreak = 1;
                }
            }

            $habitName = optional($records->first()->habit)->name ?? 'Unknown Habit';

            $streaks[$habitName] = $dates->count() ? $maxStreak : 0;
        }

        return response()->json([
            'data' => $streaks,
            'message' => 'Successfully get total streaks per habit!',
            'success' => true
        ]);
    }

    public function habitTarget(){
        
    }
}
