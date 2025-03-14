<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    

    public function Login(Request $request) : JsonResponse
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken($user->name . "Auth-Token" )->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'token_type' => "Bearer",
            'token' => $token,
            'user' => $user
        ], 201);


    }


    public function register(Request $request) : JsonResponse
    {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if($user){

            $token = $user->createToken('token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user
            ], 201);
        }else {
            return response()->json([
                'message' => 'Registration failed'
            ], 500);
        }
    }
}