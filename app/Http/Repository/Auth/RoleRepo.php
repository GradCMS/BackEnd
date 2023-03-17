<?php

namespace App\Http\Repository\Auth;

use App\Http\RepoInterfaces\RoleInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class RoleRepo implements RoleInterface
{

    /**
     * @param $name
     * @return Builder|Model|void
     */
    public function create($name)
    {
        $role = Role::create([
            'name' => $name,
            'guard_name' => 'api'   // in case multiple guards were used in the future
        ]);
        if ($role) {
            return $role;
        }
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
     *
     */
    public function delete($id)
    {
        $role = Role::findById($id);
        $role->delete();
    }

    /**
     * get all roles with related permissions
     * @return Collection|array
     */
    public function getRolesWithPermissions(): Collection|array
    {
        return Role::with('permissions')->get();
    }

    /**
     * get certain role {id} with related permissions
     * @param $id
     * @return mixed
     */
    public function getRoleWithPermissions($id):mixed
    {
        return Role::with('permissions')->find($id);
    }
}
