<?php

namespace App\Http\Repository;

use App\DTOs\ModelDTO;
use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Http\RepoInterfaces\UserRepoInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

/**
 * Post
 *
 * @mixin Builder
 */
class UserRepo implements UserRepoInterface
{

    public function create(ModelDTO $modelDTO):User
    { // TODO: save() and addRole() are not in the same transaction [open a transaction and close it for better performance]
        $role = $modelDTO->getNonFillable()['role'];

        $user = new User();
        $user = $this->fillData($modelDTO, $user);

        $user->is_suspended = false; // default value
        $user->save();

        $this->updateRoles($user, $role);

        return $user;
    }

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

    public function update($id, ModelDTO|array $newData): User
    {

        $user  = User::find($id);

        $user = $this->fillData($newData, $user);

        $user->update();

        if (isset($newData->getNonFillable()['role']))
        {
            $newRole = $newData->getNonFillable()['role'];
            $this->updateRoles($user, $newRole);
        }
        return $user;
    }
    public function updateRoles(User $user, $newRole)
    {
        $user->syncRoles($newRole);
    }


    public function fillData(ModelDTO $modelDTO, User $user): User
    {
        $fillableData = $modelDTO->getFillable();
        $user->fill($fillableData);

        if(isset($modelDTO->getNonFillable()['password']))
        {
            $user->password = $modelDTO->getNonFillable()['password'];
        }

        return $user;
    }


    /**
     * @param $id
     * @return void
     */
    public function suspendUser($id):void
    {
        $user = User::find($id);
        $user->is_suspended = true;

        $user->update();
    }

    /**
     * @param $id
     * @return void
     */
    public function unsuspendUser($id):void
    {
        $user = User::find($id);
        $user->is_suspended = false;

        $user->update();
    }

    /**
     * @return mixed
     */
    public function getSuspendedUsers(): mixed
    {
        return User::whereIsSuspended(true)->get();
    }
    
    public function getUnsuspendedUsers():mixed
    {
        return User::whereIsSuspended(false)->get();
    }

    /**
     * @return mixed
     */
    public function getUsersCount(): mixed
    {
        return User::count();
    }

    /**
     * @param $userName
     * @return mixed
     */
    public function getUserByName($userName)
    {
        return User::firstWhere('user_name', $userName);
    }
}
