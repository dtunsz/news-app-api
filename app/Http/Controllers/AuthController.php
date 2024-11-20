<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create($data);
        $token = $user->createToken($request->name);
        return[ "user" => $user, "token" => $token->plainTextToken];
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:6'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return [
                'errors' => [
                    'email' => ['The provided credentials are incorrect.']
                ]
            ];
        }

        $token = $user->createToken($user->name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }
    public function logout(Request $request) {
        // $request->user()->tokens()->delete();
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'Logout successful'
        ];
    }
    public function get_latest(Request $request) {
        $user = User::latest()->first();
        return $user;
    }
}
