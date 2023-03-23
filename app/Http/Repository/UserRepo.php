<?php

namespace App\Http\Repository;

use App\DTOs\ModelCreationDTO;
use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

/**
 * Post
 *
 * @mixin Builder
 */
class UserRepo implements CRUDRepoInterface
{

    public function getAll():Collection|array
    {
        return User::with('roles')->get();
    }

    public function getById($id)
    {
        return User::with('roles')->find($id);
    }

    public function delete($id)
    {
        return User::destroy($id);
    }

    public function create(ModelCreationDTO $modelDTO):User
    { // TODO: save() and addRole() are not in the same transaction [open a transaction and close it for better performance]

        $role = $modelDTO->getNonFillable()['role'];
        $user = new User();

        $user = $this->fillData($modelDTO, $user);

        $user->save();
        $this->addRole($user, $role);
        return $user;
    }

    public function update($id, ModelCreationDTO $modelDTO)
    { // TODO: instead of using update function use the fill method

        $user  = User::find($id);

        $user = $this->fillData($modelDTO, $user);

        $user->update();

        if (isset($modelDTO->getNonFillable()['role']))
        {
            $newRole = $modelDTO->getNonFillable()['role'];
            $this->updateRoles($id, $newRole);
        }
        return $user;
    }
    public function updateRoles($id, $newRole)
    {
        $user = User::find($id);
        $user->syncRoles($newRole);
    }
    public function addRole(User $user, $role)
    {
        $user->assignRole($role);
    }

    public function fillData(ModelCreationDTO $modelDTO, User $user): User
    {
        $fillableData = $modelDTO->getFillable();


        $user->fill($fillableData);

        if(isset($modelDTO->getNonFillable()['password']))
        {
            $user->password = $modelDTO->getNonFillable()['password'];
        }



        return $user;
    }


}
