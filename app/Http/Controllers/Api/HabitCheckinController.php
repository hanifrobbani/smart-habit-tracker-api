<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Habit;
use App\Models\HabitCheckins;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HabitCheckinController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $id)
    {
  
        $habit = Habit::findOrFail($id);
        $user = Auth::user();
        $checkinDate = Carbon::now()->toDateString();

        $existingCheckinToday = HabitCheckins::where('habit_id', $habit->id)
            ->where('user_id', $user->id)
            ->where('checkin_date', $checkinDate)
            ->first();

        if ($existingCheckinToday) {
            return response()->json(['message' => 'You have already checked in for this habit today.'], 409);
        }

        try {
            $checkin = HabitCheckins::create([
                'habit_id' => $habit->id,
                'user_id' => $user->id,
                'checkin_date' => $checkinDate,
            ]);
            $habit->longest_streak = $habit->longest_streak + 1;
            $habit->save();

            return response()->json([
                'message' => 'Habit checked in successfully!',
                'checkin' => $checkin,
                'streaks' => $habit->longest_streak
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to check in habit.', 'error' => $e->getMessage()], 500);
        }
    }
}
