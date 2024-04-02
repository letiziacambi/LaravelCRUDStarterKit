<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $credentialsEmail = ['email' => $request->input('username'), 'password' => $request->input('password')];
        $credentialsUsername = ['name' => $request->input('username'), 'password' => $request->input('password')];

        if (Auth::attempt($credentialsEmail) || Auth::attempt($credentialsUsername)) {
            $request->session()->regenerate();
            return response()->json([
                'authenticated' => true
            ]);
        }
        return response()->json([
            'authenticated' => false,
            'error' => 'The provided credentials do not match our records.'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return true;
    }

    public function me()
    {
        return Auth::user();
    }
}
