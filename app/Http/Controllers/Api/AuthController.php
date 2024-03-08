<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if (!auth()->attempt($loginData)) {
            return response([
                'response' => 'Invalid credentials',
                'message' => 'error']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response ([
            'profile' => auth()->user(),
            'access_token' => $accessToken,
            'message' => 'success'
        ]);
    }
}
