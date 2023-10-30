<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    private $user;
    public function __construct()
    {
        $this->user = new User();
    }

    public function register(Request $request){
        //validator request before handle data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required',
        ]);
        //check request has any errors then return messages errors
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ],400);
        }


        //if request no errors then create user with request
        //after creating the user, return message created success and user info
        $user = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->get('password'))
        ]);
        return response()->json([
            'message'=> 'User created successfully',
            'data'=>$user,
        ],200);
    }

    public function login(Request $request){
        //validator request before handle data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        //check request has any errors then return messages errors
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ],400);
        }

        //if request no errors then get request info
        $credentials = $request->only('email', 'password');
        //authen user in database. if user not have(null) return error
        //if user have database then return token
        $token = null;
            if (!($token = auth()->attempt($credentials))) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        return response()->json([
            'token' => $token,
        ], 200);
    }

    //logout user
    public function logout(){
        auth()->logout();
        return response()->json([
            'message' => 'User logout successfully'
        ],201);
    }

}
