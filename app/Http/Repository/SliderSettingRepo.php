<?php

namespace App\Http\Repository;
use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\SliderSetting;
use Illuminate\Database\Eloquent\Builder;

/**
 * Post
 *
 * @mixin Builder
 */
class SliderSettingRepo implements CRUDRepoInterface
{

    public function getAll()
    {
        return SliderSetting::all();
    }

    public function getById($id)
    {
        return SliderSetting::Query()->findOrFail($id);
    }

    public function delete($id)
    {
        return SliderSetting::destroy($id);
    }

    public function create($modelDetails)
    {
        return SliderSetting::Query()->create($modelDetails);
    }

    public function update($id, $modelDetails)
    {
        return SliderSetting::Query()->where($id)->update($modelDetails);
    }
}
