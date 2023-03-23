<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\Auth\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

//use Illuminate\Validation\ValidationException;


class RoleController extends Controller
{
    private $roleService;
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * create a new role with specific permissions
     *
     * creates the role then updates it with the permissions
     *
     * uses the helper function "validate" to make the validation in case of validating a request
     *
     * @param Request $request
     * @return JsonResponse;
     *
    */
    public function createRole(Request $request): JsonResponse
    { // TODO: check and try to optimize the number of calls to the database

        $validator = Validator::make($request->all(), [
            'name'=>'required|unique:roles,name', // 1 call
            'permissions' => ['required', 'array'],
            'permissions.*' => ['exists:permissions,name'], // 2  calls
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $data = [
          'name'=>$request->input('name'),
          'permissions'=>$request->input('permissions')
        ];

        $role = $this->roleService->createRole($data); // 3 calls

        return response()->json([
            'message'=>'Role created successfully',
            'role'=>$role
        ], 201);

    }

    /**
     * gets all the roles with their permissions
     * @return JsonResponse
    */
    public function getAllRoles():JsonResponse
    { // TODO: use pagination

        $roles = $this->roleService->getAllRoles();

        return response()->json([
           'roles'=>$roles
        ]);
    }

    /**
     * delete a certain role
     * here the Validator facade is used directly because there isn't a Request object to use the helper function
     * @param  $id
     * @return JsonResponse
     */
    public function deleteRole($id):JsonResponse
    {
        // validates the data type of the $id and throw exception if not valid
        $validator = Validator::make(['id' => $id], [ // TODO: is this worth validation?
            'id' => 'required|integer|exists:roles'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $this->roleService->deleteRole($id);

        return response()->json([
                'message'=>'Role with ID '.$id.' has been deleted successfully'
            ]);
    }

    /**
     * update permissions of certain role
     *
     * in case of validating a Request object and a param: use the "Validator" facade directly
     *
     * @param Request $request
     * @param $roleId
     * @return JsonResponse
     */
    public function updateRole(Request $request, $roleId): JsonResponse
    {
        $validator = Validator::make($request->all() + ['id'=>$roleId],[
            'id' => 'required|integer|exists:roles',
            'permissions' => 'array|nullable',
            'name'=> Rule::unique('roles', 'name')->ignore($roleId),
            'permissions.*' => 'exists:permissions,name'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data =[
            'name'=>$request->input('name') ?? null,
            'permissions'=>$request->input('permissions') ?? null
        ];

        $data = array_filter($data, function($value, $key) { // deletes all the null entries from the array
            return $value !== null;
        }, ARRAY_FILTER_USE_BOTH);

        $role = $this->roleService->updateRole($roleId, $data);

//        $newRole = $this->roleService->getRole($roleId); // add it later in case needed {gets the updated role}

        return response()->json([
            'message'=>'Role updated successfully',
            'Role'=>$role
        ]);
    }


}
