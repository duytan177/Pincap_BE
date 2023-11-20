<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\AuthRepo\AuthRepo;
use App\Repositories\AuthRepo\AuthRepoInterface;
use auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    protected $authRepo;
    public function __construct(AuthRepo $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function register(Request $request){

        //validator request before handle data
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:20',
            'lastName' => 'required|string|max:20',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
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
        $userData = [
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => $request->password
        ];
        $this->authRepo->register($userData);

        return response()->json([
            'message'=> 'User created successfully',
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
            if (!($token = $this->authRepo->login($credentials))) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        return response()->json([
            'token' => $token,
        ], 200);
    }

    //logout user
    public function logout(){
            $this->authRepo->logout();
            return response()->json([
                'message' => 'User logout successfully'
            ],201);
    }


}
