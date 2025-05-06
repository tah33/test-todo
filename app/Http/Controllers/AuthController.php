<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                auth()->user()->tokens()->delete();
                $token = $request->user()->createToken($request->email);
                $user_data = \auth()->user()->toArray();
                $user_data['token'] = $token->plainTextToken;

                return response()->json([
                    'message'   => 'Logged in successfully',
                    'success'   => true,
                    'user'      => $user_data,
                ]);
            } else {
                return response()->json([
                    'message' => 'Invalid Credentials',
                    'success' => false,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
            ]);
        }
    }

    public function register(UserRequest $request): JsonResponse
    {
        try {
            $data = $request->all();
            $data['email_verified_at'] = now();
            $user = User::create($data);
            $token = $user->createToken($request->email);
            $user_data = $user->toArray();
            $user_data['token'] = $token->plainTextToken;
            return response()->json([
                'message'   => 'Registered successfully',
                'success'   => true,
                'user'      => $user_data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function me(Request $request): JsonResponse
    {
        try {
            $user_data = \auth()->user()->toArray();

            return response()->json([
                'message'   => 'Me',
                'success'   => true,
                'user'      => $user_data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function logout()
    {
        try {
            auth()->user()->tokens()->delete();
            return response()->json([
                'message' => 'Logged out successfully',
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
