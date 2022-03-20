<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login($request)
    {
        $user = User::where('email', $request['email']);
        if (!$user) {
            return \response(['No user found', 404]);
        }
        if (Hash::check($request['password'], $user->password)) {
            return \response('Authentication success!', 200);
        }
        return \response(['Incorrect password', 401]);
    }
}
