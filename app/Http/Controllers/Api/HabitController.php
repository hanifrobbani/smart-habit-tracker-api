<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Habit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HabitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Habit::latest()->get();
        return response()->json([
            'data' => $data,
            'message' => 'Successfully get habit data',
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
            'name' => 'required|max:255',
            'categories_id' => 'required',
            'goal' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        try {
            $data = Habit::create([
                ...$validate->validated(),
                'user_id' => $user->id,
            ]);

            return response()->json([
                'message' => 'Habit Sucessfuly created!',
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
        $data = Habit::findOrFail($id);
        $validate = Validator::make($request->all(), [
            'name' => 'sometimes|max:255',
            'categories_id' => 'sometimes|exists:categories,id',
            'goal' => 'sometimes',
        ]);


        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        try {
            $data->update($validate->validated());
            return response()->json([
                'message' => 'Habit Sucessfuly updated!',
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
        $data = Habit::findOrFail($id);
        $data->delete();

        return response()->json([
            'message' => 'Habit Sucessfuly deletdd!',
            'success' => true,
            'data' => $data
        ], 200);
    }
}
