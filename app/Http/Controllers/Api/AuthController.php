<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        try {
            $validatedData = $validate->validated();
            $validatedData['password'] = Hash::make($validatedData['password']);
            $user = User::create($validatedData);

            return response()->json([
                "data" => $user,
                "message" => "User successfully register!",
                "success" => true
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                "error" => $e->getMessage(),
                "success" => false
            ], 500);
        }

    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        try {
            if (!$token = Auth::guard('api')->attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials.',
                ], 401);
            }

            $user = Auth::guard('api')->user();

            return response()->json([
                'success' => true,
                'user' => $user,
                'token' => $token,
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout()
    {
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if ($removeToken) {
            return response()->json([
                'success' => true,
                'message' => 'Logout Success!',
            ], 200);
        }
    }
}