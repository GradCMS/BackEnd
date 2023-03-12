<?php

namespace App\Http\Repository;

use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\Display;
use Illuminate\Database\Eloquent\Builder;

/**
 * Post
 *
 * @mixin Builder
 */
class DisplayRepo implements CRUDRepoInterface
{

    public function getAll()
    {
        return Display::all();
    }

    public function getById($id)
    {
        return Display::Query()->findOrFail($id);
    }

    public function delete($id)
    {
        return Display::destroy($id);
    }

    public function create(array $modelDetails)
    {
        return Display::Query()->create($modelDetails);
    }

    public function update($id, array $modelDetails)
    {
        return Display::Query()->where($id)->update($modelDetails);
    }
}
