<?php

namespace App\Http\Repository;
use App\DTOs\ModelDTO;
use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\SliderSetting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Post
 *
 * @mixin Builder
 */
class SliderSettingRepo implements CRUDRepoInterface
{

    public function getAll(): Collection|array
    {
        return SliderSetting::all();
    }

    public function getById($id)
    {
        return SliderSetting::find($id);
    }

    public function delete($id)
    {
        SliderSetting::destroy($id);
    }

    public function create($modelDTO): SliderSetting
    {
       $sliderSetting = new SliderSetting();

       $sliderSetting->fill($modelDTO->getFillable());
       $sliderSetting->save();

       return $sliderSetting;
    }

    public function update($id, ModelDTO|array $newData)
    {
       $sliderSetting = SliderSetting::find($id);

       $sliderSetting->update($newData); // data is passed as array because all attributes are fillable
    }
}
