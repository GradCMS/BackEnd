<?php

namespace App\Http\Controllers;


use App\Http\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function createUser(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role'=>'required|exists:roles,name'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userData = [
            'user_name' => $request->input('user_name'),
            'email'=> $request->input('email'),
            'password'=> $request->input('password'),
            'role'=>$request->input('role'),
        ];

        $user = $this->userService->createUser($userData);

        return response()->json([
            'message'=>'User has been created successfully',
            'user'=>$user
        ], 201);

    }

    public function getUsers():JsonResponse
    {
        $users = $this->userService->getAllUsers();
        return response()->json([
           'users'=>$users
        ]);
    }

    public function getSuspendedUsers():JsonResponse
    {
        $users = $this->userService->getSuspendedUsers();
        return response()->json([
            'suspended users'=>$users
        ]);
    }
    public function getUsersCount():JsonResponse
    {
        $count = $this->userService->getUsersCount();
        return response()->json([
            'count'=>$count
        ]);
    }

    public function deleteUser($id):JsonResponse
    {
        $validator = Validator::make(['id' => $id], [ // TODO: is this worth validation?
            'id' => 'required|integer|exists:users'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $this->userService->deleteUser($id);

        return response()->json([
            'message'=>'User with ID '.$id.' has been deleted successfully'
        ]);
    }

    public function updateUser(Request $request, $userId):JsonResponse
    {

        $validator = Validator::make($request->all()+['id' => $userId], [
            'id' => 'required|integer|exists:users',
            'role'=>'nullable|exists:roles,name',
            'email' => [
                'email',
                'nullable',
                Rule::unique('users', 'email')->ignore($userId)
            ],

            'user_name'=> Rule::unique('users', 'user_name')->ignore($userId),

            'password' => 'min:6|confirmed|nullable',
            // TODO: validate on user_name/email uniqness after updating
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userData = [
            'user_name' => $request->input('user_name') ?? null,
            'email'=> $request->input('email')?? null,
            'password'=> $request->input('password')?? null,
            'role'=>$request->input('role')?? null,
        ];

        $userData = array_filter($userData, function($value, $key) { // deletes all the null entries from the array
            return $value !== null;
        }, ARRAY_FILTER_USE_BOTH);


        $user = $this->userService->updateUser($userId, $userData);

        return response()->json([
            'message'=>'User with ID '.$userId.' has been updated successfully',
            'updated_user'=>$user
        ]);
    }

    public function suspendUser($id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:users',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $this->userService->suspendUser($id);

        return response()->json([
            'message'=>'User with ID '.$id.' has been suspended successfully',
        ]);

    }

    public function unsuspendUser($id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:users',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $this->userService->unsuspendUser($id);

        return response()->json([
            'message'=>'User with ID '.$id.' has been unsuspended successfully',
        ]);

    }

}
