<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\Auth\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

        try{
            $validatedData = $request->validate([
                'name'=>'required|unique:roles,name', // 1 call
                'permissions' => ['required', 'array'],
                'permissions.*' => ['exists:permissions,name'], // 2  calls
            ]);
        }catch (ValidationException $e){
            return response()->json(['errors' => $e->errors()], 422);
        }

        $data = ['name'=>$validatedData['name']];
        $permissions = $validatedData['permissions'];

        $role = $this->roleService->createRole($data); // 3 calls
        $this->roleService->updatePermissionsInRole($role->id, $permissions); // 4 calls

        return response()->json([
            'message'=>'Role created successfully',
            'role'=>$this->roleService->getRolewithPermissions($role->id), // 5 calls
        ], 201);

    }

    /**
     * gets all the roles with their permissions
     * @return JsonResponse
    */
    public function getAllRoles():JsonResponse
    { // TODO: use pagination

        $roles = $this->roleService->getRolesWithPermissions();

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

        $validator = Validator::make(['id' => $id], [
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
    public function updatePermissions(Request $request, $roleId): JsonResponse
    {
        $validator = Validator::make($request->all() + ['id'=>$roleId],[
            'id' => 'required|integer|exists:roles',
            'permissions' => ['required', 'array'],
            'permissions.*' => ['exists:permissions,name']
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $permissions = $request->input('permissions');
        $this->roleService->updatePermissionsInRole($roleId, $permissions);
        $newRole = $this->roleService->getRolewithPermissions($roleId);

        return response()->json([
            'message'=>'Role updated successfully',
            'Role'=>$newRole
        ]);
    }


}
