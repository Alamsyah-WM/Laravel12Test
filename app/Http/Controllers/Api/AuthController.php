<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=> 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be fill',
                'error' => $validator->messages(),
            ],422);
        }

        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> $request->password
        ]);

        $token = $user->createToken($request->name);

        return response()->json([
            'user' =>$user,
            'token' => $token->plainTextToken
        ],200);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Authentication Error',
                'error' => $validator->messages(),
            ],422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)){
            return [
                'message' => 'The provided credentials are incorrect'
            ];
        }
        
        $token = $user->createToken($user->name);

        return response()->json([
            'user' =>$user,
            'token' => $token->plainTextToken
        ],200);
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();

        return [
            'message' => 'You are logged out'
        ];
    }
}
