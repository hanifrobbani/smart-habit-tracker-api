<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HabitReminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;
class ReminderHabitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => HabitReminder::all(),
            'messsage' => 'Successfully get data reminder habit',
            'success' => true
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validate = Validator::make($request->all(), [
            'habit_id' => 'required|exists:habits,id',
            'reminder_time' => 'required',
            'days' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        try {
            $data = HabitReminder::create([
                ...$validate->validated(),
                'user_id' => $user->id,
            ]);

            return response()->json([
                'message' => 'Reminder habit successfully created!',
                'success' => true,
                'data' => $data
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = HabitReminder::findOrFail($id);
        $validate = Validator::make($request->all(), [
            'habit_id' => 'sometimes|exists:habits,id',
            'reminder_time' => 'sometimes',
            'days' => 'sometimes',
            'is_active' => 'sometimes|boolean',
        ]);


        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        try {
            $data->update($validate->validated());
            return response()->json([
                'message' => 'Reminder Habit Sucessfuly updated!',
                'success' => true,
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = HabitReminder::findOrFail($id);

        try {
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'Reminder Habit successfully deleted',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
