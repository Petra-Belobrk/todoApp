<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
//
//    public function login(Request $request)
//    {
//        $loginData = $request->validate([
//            'email' => 'email|required',
//            'password' => 'required'
//        ]);
//
//        if(!auth()->attempt($loginData)) {
//            return response(['message'=>'Invalid credentials']);
//        }
//
//        $accessToken = auth()->user()->createToken('authToken')->accessToken;
//
//        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
//
//
//    }
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @return [string] access_token
     * @return [string] token_type
     */
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
//        $credentials = request(['email', 'password']);

        if(!Auth::attempt($loginData)){
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
        };

        $user = $request->user();
        $tokenResult = $user->createToken('authToken');
        $token = $tokenResult->token;
//
//        if ($request->remember_me)
//        $token->expires_at = Carbon::now()->addWeeks(1);
//        $token->save();
//
        return response()->json([
        'access_token' => $tokenResult->accessToken,
        'token_type' => 'Bearer',
//        'expires_at' => Carbon::parse(
//            $tokenResult->token->expires_at
//        )->toDateTimeString()
    ]);
    }
    public function register(Request $request)
    {

        $request->validate([
            'name'=>'required|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user'=> $user, 'access_token'=> $accessToken]);

    }

    public function logout()
    {

        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json('Logged out successfully', 200);
    }
}
