<?php

namespace App\Http\Repository;

use App\DTOs\ModelDTO;
use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\Display;
use Illuminate\Database\Eloquent\Collection;

class DisplayRepo implements CRUDRepoInterface
{


    public function create($modelDTO): Display
    {
        $display = new Display();

        $display->fill($modelDTO->getFillable());
        $display->save();

        return $display;
    }


    public function getAll(): Collection|array
    {
        $displays = Display::all();

        foreach ($displays as $display) {
            if (!is_null($display->slider_settings_id)) {
                $display->load('sliderSetting');
            } elseif (!is_null($display->grid_settings_id)) {
                $display->load('gridSetting');
            }
        }

        return $displays;

    }


    public function getById($id)
    {
        $display = Display::find($id);

        if (!is_null($display->slider_settings_id)) {
            $display->load('sliderSetting');
        } elseif (!is_null($display->grid_settings_id)) {
            $display->load('gridSetting');
        }

        return $display;

    }



    public function delete($id)
    {
       Display::destroy($id);
    }


    public function update($id, ModelDTO|array $modelDetails):Display
    {
        $display = Display::findOrFail($id);

        $display =$this->fillData($modelDetails,$display);

        $display->update();

        return $display;
    }

    public function fillData($modelDTO, Display $display): Display
    {
        $fillableData = $modelDTO->getFillable();

        $display->fill($fillableData);

        return $display;
    }
}
