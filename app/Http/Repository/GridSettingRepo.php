<?php

namespace App\Http\Repository;
use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\GridSetting;
use Illuminate\Database\Eloquent\Builder;

/**
 * Post
 *
 * @mixin Builder
 */
class GridSettingRepo implements CRUDRepoInterface
{

    public function getAll()
    {
        return GridSetting::all();
    }

    public function getById($id)
    {
        return GridSetting::Query()->findOrFail($id);
    }

    public function delete($id)
    {
        return GridSetting::destroy($id);
    }

    public function create($modelDTO)
    {
        return GridSetting::Query()->create($modelDTO);
    }

    public function update($id, $newData)
    {
        return GridSetting::Query()->where($id)->update($newData);
    }
}
