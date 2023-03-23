<?php

namespace App\Http\Repository\Auth;

use App\DTOs\ModelDTO;
use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Http\RepoInterfaces\RoleInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class RoleRepo implements CRUDRepoInterface
{

    /**
     * @param ModelDTO $modelDTO
     * @return Model
     */
    public function create(ModelDTO $modelDTO): Role
    {
        $permissions = $modelDTO->getNonFillable()['permissions'];

//        $role = Role::create([
//            'name' => $name,
//            'guard_name' => 'api'   // in case multiple guards were used in the future
//        ]);

        $role = new Role();

        $role = $this->fillData($modelDTO, $role);

        $role->save();
        $this->updatePermissions($role, $permissions);

        return $role;

    }

    /**
     * @return Collection|Role[]
     */
    public function getAll(): Collection|array
    {
        return Role::with('permissions')->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id): mixed
    {
        return Role::with('permissions')->find($id);
    }

    public function delete($id)
    {
        $role = Role::findById($id);
        $role->delete();
    }

    /**
     * @param $id
     * @param  $newPermissions
     * permissions are provided by permission names not the actual objects
     * @return void
     */
    public function update($id, ModelDTO $modelDTO):Role
    {
        $role = Role::findById($id);

        $role = $this->fillData($modelDTO, $role);

        $role->update();

        if(isset($modelDTO->getNonFillable()['permissions']))
        {
            $newPermissions = $modelDTO->getNonFillable()['permissions'];
            $this->updatePermissions($role, $newPermissions);
        }
        return $role;
    }
    /**
     * @param $id
     *
     */


    public function updatePermissions(Role $role, $permissions)
    {
        $role->syncPermissions($permissions);
    }

    public function fillData(ModelDTO $modelDTO, Role $role): Role
    {

        $fillableData = $modelDTO->getFillable();
        $role->fill($fillableData);

        if(isset($modelDTO->getNonFillable()['name']))
        {
            $role->name = $modelDTO->getNonFillable()['name'];
        }
        $role->guard_name = "api";

        return $role;
    }

}
