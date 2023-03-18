<?php

namespace App\Http\Controllers;


use App\Http\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function createUser(Request $request):JsonResponse
    { // TODO: add Roles when creating the user
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userData = [
            'user_name' => $request->input('user_name'),
            'email'=> $request->input('email'),
            'password'=> $request->input('password')
        ];

        $user = $this->userService->createUser($userData);

        return response()->json([
            'message'=>'User has been created successfully',
            'user'=>$user
        ], 201);

    }

    public function getUsers()
    {

    }

    public function deleteUser()
    {

    }

    public function suspendUser()
    {

    }


    public function updateRoles()
    {

    }



}
