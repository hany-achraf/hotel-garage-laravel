<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $user = User::where('email', $request->input('email'))->first();

            if (!$user || !Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'message' => 'Invalid login details',
                ], 401);
            }
            
            // $token = $user->createToken($request->input('device_id'))->plainTextToken;
            $token = $user->createToken($request->input('email'))->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
