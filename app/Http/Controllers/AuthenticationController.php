<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        $request ->validate([
            'firstname' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'username'      => $request->username,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
        ]);

        if($user) {
            return response()->json([
                'success' => true,
                'user'    => $user,  
            ], 201);
        }

        return response()->json([
            'success' => false,
        ], 409);
    }

    public function login(Request $request){
        $request -> validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        // dd($user);

        if(!$user || ! Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'account' => ['The provided credentials are incorrect'],
            ]);
        }

        return $user->createToken('user login')->plainTextToken;
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete;

        return response()->json(['message' => 'anda sudah logout']);
    }

    public function me(Request $request){
        $user = Auth::user();
        return response()->json($user);
    }
}
