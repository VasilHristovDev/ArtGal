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

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'age' => $request['age'],
            'password' => Hash::make($request['password'])
        ]);

        $token = $user->createToken('authToken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response,201);

    }
}
