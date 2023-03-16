<?php

namespace App\Http\Repository;

use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Http\RepoInterfaces\RoleInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

class RoleRepo implements RoleInterface
{

    /**
     * @param $name
     * @return void
     */
    public function create($name):void
    {
        Role::create([
            'name'=>$name,
            'guard_name'=>'api'   // in case multiple guards were used in the future
        ]);
    }

    /**
     * @return Role[]
     */
    public function getAll():array
    {
        return Role::all();
    }

    /**
     * @param $id
     * @return Role
     */
    public function getById($id):Role
    {
        return Role::findById($id);
    }

    /**
     * @param $id
     * @param  $newPermissions
     * permissions are provided by permission names not the actual objects
     * @return void
     */
    public function update($id,$newPermissions):void
    {
        $role = Role::findById($id);
        $role->syncPermissions($newPermissions);
    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id):void
    {
        $role = Role::findById($id);
        $role->delete();
    }

    /**
     * @return Collection|array
     */
    public function getRolesWithPermissions(): Collection|array
    {
        return Role::with('permissions')->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getPermissionsOfRole($id):mixed
    {
        return Role::with('permissions')->find($id);
    }
}
