<?php

namespace App\Http\Repository;

use App\DTOs\ModelDTO;
use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\Display;

class DisplayRepo implements CRUDRepoInterface
{


    /**
     * @param array $modelDTO
     * @return mixed
     */
    public function create($modelDTO)
    {
        return Display::Query()->create($modelDTO);
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return Display::all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return Display::Query()->findOrFail($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return Display::destroy($id);
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
