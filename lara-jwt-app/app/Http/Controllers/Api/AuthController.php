<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name'=>'required|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|confirmed',
        ]);
        $user =User::create($request->all());
        return response()->json([
            'success'=>true,
            'massage'=>'Registion SuccessFull .',
            'data'=>$user
        ],201);
    }
    public function login(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        $user = User::where('email',$request->email)->first();
        if(!$user){
            return response()->json([
                'error'=>true,
                'message'=>'Email Does not match!',
            ],401);     
        }else{
            if(Hash::check($request->password,$user->password)){
                // $token =JWTAuth::fromUser($user);       //fromUser buildin //another way down for custom
                
                $custom = time() + (5);
                $token = JWTAuth::claims([
                    'exp'=>$custom,
                    'user-name'=>$user->name,
                ])->fromUser($user);

                return response()->json([
                    'success'=>true,
                    'message'=>'login SuccessFull.',
                    'data'=>$user,
                    'token'=>$token,
                ],201);
            }else{
                return response()->json([
                    'error'=>true,
                    'message'=>'Password Does Not Match',
                ],401);
            }
        }
    }
    public function logout(){
        
        return response()->json([
            'success'=>true,
            'message'=>'logout SuccessFull',
        ]);
    }
}
