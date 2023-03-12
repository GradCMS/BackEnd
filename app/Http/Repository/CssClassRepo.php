<?php

namespace App\Http\Repository;

use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\CssClass;
use Illuminate\Database\Eloquent\Builder;

/**
 * Post
 *
 * @mixin Builder
 */
class CssClassRepo implements CRUDRepoInterface
{

    public function getAll()
    {
        return CssClass::all();
    }

    public function getById($id)
    {
        return CssClass::Query()->findOrFail($id);
    }

    public function delete($id)
    {
        return CssClass::destroy($id);
    }

    public function create(array $modelDetails)
    {
        return CssClass::Query()->create($modelDetails);
    }

    public function update($id, array $modelDetails)
    {
        return CssClass::Query()->where($id)->update($modelDetails);
    }
}
