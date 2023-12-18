<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class JwtBrowserController extends Controller
{
    public function __construct()
    {
        $this->middleware('from.session.to.bearer');
        $this->middleware('jwt.verify', ['except' => ['autoLogin']]);
    }

    public function autoLogin() {

        $user = User::first();
        $token = auth()->attempt([
            'email' => $user->email,
            'password' => 'password',
        ]);

        // save token into headers session
        session(['token' => $token]);

        return response()->json([
            'message' => 'User logged in and access token stored to session ' . $token
        ]);
    }

    public function secretData(): JsonResponse
    {
        return response()->json([
            'data' => 'Some secret data',
            'token' => request()->headers->get('authorization')
        ]);
    }
}
