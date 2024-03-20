<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
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

    public function register(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'required',
            'password' => 'required',
            'profile_photo' => 'required|max:55',
            'bio' => 'required'
        ]);

        $validatedData['password'] = bcrypt($request->password);
        $user = User::create($validatedData);
        $accessToken = $user->createToken('authToken')->accessToken;

        return response([ 'profile' => $user, 'access_token' => $accessToken]);
    }

}
