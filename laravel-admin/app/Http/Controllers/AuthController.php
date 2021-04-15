<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Cookie;


class AuthController extends Controller
{
    //
    public function login(Request $request){
        
        if(Auth::attempt($request->only('email', 'password'))){
            $user = Auth::user();

            
            $token = $user->createToken('admin')->accessToken;
          
            
            return response([
                "token" => $token, 
            ])->cookie('jwt', $token);
        }

        return response([
            'error' => 'Invalid Login'
        ], Response::HTTP_UNAUTHORIZED);

    }

    public function logout(){
        $cookie = \Cookie::forget('jwt');

        return response([
            'message'=>'success',
        ])->withCookie($cookie);
    }

    public function register(RegisterRequest $request){
    
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' =>$request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role_id' => '2',
           
        ]);

        return response($user, Response::HTTP_CREATED);
    }
}
