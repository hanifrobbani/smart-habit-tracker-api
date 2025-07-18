<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Habit;
use App\Models\HabitCheckins;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class HabitCheckinController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $id)
    {
  
        $habit = Habit::findOrFail($id);
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
        }

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

            return response()->json([
                'message' => 'Habit checked in successfully!',
                'checkin' => $checkin
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to check in habit.', 'error' => $e->getMessage()], 500);
        }
    }
}
