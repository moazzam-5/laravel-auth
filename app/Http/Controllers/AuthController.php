<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->all(); // This will get all the request data.
    $userCount = User::where('email', $data['email']);
    if ($userCount->count()) {
        return response([
            'message' => 'email already exist'
        ]);
    } else {
       $user = new User;
       $user->name = $request->name;
       $user->email = $request->email;
       $user->password = Hash::make($request->password);
       $user->save();
        return response([
            'message' => 'success'
        ]);
    }
        // dd($request->name, $request->email, $request->password); 
    
        
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'success' => 'false', 
                'message' => 'Invalid credentials!'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();

        $token = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 60 * 24); // 1 day

        return response([
            'success' => 'true',
            'token' => $token
        ])->withCookie($cookie);
    }

    public function user()
    {
        return Auth::user();
    }
    public function allUsers()
    {
        return User::all();
    }

    public function logout()
    {
        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'Success'
        ])->withCookie($cookie);
    }

}
