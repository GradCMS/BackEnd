<?php

namespace App\Http\Repository;

use App\DTOs\ModelCreationDTO;
use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Post
 *
 * @mixin Builder
 */
class UserRepo implements CRUDRepoInterface
{

    public function getAll()
    {
        return User::all();
    }

    public function getById($id)
    {
        return User::Query()->findOrFail($id);
    }

    public function delete($id)
    {
        return User::destroy($id);
    }

    public function create(ModelCreationDTO $modelDTO):User
    {
        $fillableData = $modelDTO->getFillable();
        $password = $modelDTO->getNonFillable()['password'];
        $user = new User();
        $user->fill($fillableData);

        $user->password = $password;

        $user->save();
        return $user;
    }


    public function update($id, $modelDetails)
    {
        return User::Query()->where($id)->update($modelDetails);
    }
}
