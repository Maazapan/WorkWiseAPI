<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //


    public function login(Request $request) {
        $loginData = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(!auth()->attempt($loginData))
        {
            return response()->json([
                'response' => 'Contraseña o correo incorrecto',
                'success' => false
            ], 401);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response()->json([
            'profile' => auth()->user(),
            'access_token' => $accessToken,
            'success' => true
        ]);
    }


    public function logout(Request $request) {

        $request->user()->token()->revoke();

        return response()->json([

            'message' => 'Successfully logged out'
        ]);
    }
}
