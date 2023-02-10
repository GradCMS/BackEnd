<?php
namespace App\Http\Repository;

use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Builder;

/**
 * Post
 *
 * @mixin Builder
 */
class PermissionRepo implements CRUDRepoInterface{

    public function getAll()
    {
        // TODO: Implement getAll() method.
        return Permission::all();
    }

    public function getById($id)
    {
        // TODO: Implement getById() method.
        return Permission::Query()->findOrFail($id);
    }

    public function delete($id): int
    {
        // TODO: Implement delete() method.
        return Permission::destroy($id);
    }

    public function create(array $modelDetails)
    {
        // TODO: Implement create() method.
        return Permission::Query()->create($modelDetails);
    }

    public function update($id, array $modelDetails): int
    {
        // TODO: Implement update() method.
        return Permission::Query()->where($id)->update($modelDetails);
    }
}
