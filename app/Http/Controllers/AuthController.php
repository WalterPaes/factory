<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();

        if (is_null($user) || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Username or Password is invalid'], 401);
        }

        if (!$user->status) {
            return response()->json(['message' => 'This User is inactive'], 401);
        }

        $token = JWT::encode(
            ['username' => $request->username],
            env('JWT_KEY')
        );

        return [
            'user' => [
                'username' => $request->username
            ],
            'access_token' => $token
        ];
    }
}
