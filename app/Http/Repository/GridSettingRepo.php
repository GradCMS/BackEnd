<?php

namespace App\Http\Repository;

use App\DTOs\ModelDTO;
use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\GridSetting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Post
 *
 * @mixin Builder
 */
class GridSettingRepo implements CRUDRepoInterface
{

    public function create(ModelDTO $modelDTO):GridSetting
    {
        $gridSetting = new GridSetting();

        $gridSetting->fill($modelDTO->getFillable());
        $gridSetting->save();

        return $gridSetting;
    }


    public function getAll(): Collection|array
    {
        return GridSetting::all();
    }


    public function getById($id)
    {
        return GridSetting::find($id);
    }


    public function update($id, ModelDTO|array $newData)
    {
        $gridSetting = GridSetting::find($id);

        $gridSetting->update($newData); // data is passed as array because all the attributes are fillable
    }


    public function delete($id)
    {
        GridSetting::destroy($id);
    }


}
