<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
//        $validator = Validator::make($request->all(), [
//            'name' => 'required|string|max:255',
//            'email' => 'required|string|email|max:255|unique:users',
//            'password' => 'required|string|min:8',
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json($validator->errors(), 422);
//        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token,
        ]);
    }


    public function login(Request $request)
    {


        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = auth()->user();
        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token,
        ]);
    }

}
