<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed',
            'age' => 'required|numeric'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'age' => $fields['age'],
            'password' => Hash::make($fields['password'])
        ]);

        $token = $user->createToken('authToken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response,201);

    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user->password))
        {
            return response([
                'Bad input :(',
                401
            ]);
        }
        $token = $user->createToken('authToken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response,201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response([
            'Logged out',
            200
        ]);
    }
}