<?php

namespace App\Http\Repository;

use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\Module;
use Illuminate\Database\Eloquent\Builder;

/**
 * Post
 *
 * @mixin Builder
 */
class ModuleRepo implements CRUDRepoInterface
{

    public function getAll()
    {
        return Module::all();
    }

    public function getById($id)
    {
        return Module::Query()->findOrFail($id);
    }

    public function delete($id)
    {
        return Module::destroy($id);
    }

    public function create(array $modelDetails)
    {
        return Module::Query()->create($modelDetails);
    }

    public function update($id, array $modelDetails)
    {
        return Module::Query()->where($id)->update($modelDetails);
    }
}
