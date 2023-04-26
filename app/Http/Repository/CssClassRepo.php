<?php

namespace App\Http\Repository;

use App\DTOs\ModelDTO;
use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\CssClass;

class CssClassRepo implements CRUDRepoInterface
{


    /**
     * @param array $modelDTO
     * @return mixed
     */
    public function create($modelDTO): mixed
    {
        return CssClass::Query()->create($modelDTO);
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return CssClass::all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return CssClass::Query()->findOrFail($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return CssClass::destroy($id);
    }

    public function update($id,ModelDTO|array $modelDetails): CssClass
    {
        $cssClass = CssClass::findOrFail($id);

        $cssClass = $this->fillData($modelDetails, $cssClass);

        $cssClass->update();

        return $cssClass;

    }

    public function fillData($modelDTO, CssClass $cssClass): CssClass
    {
        $fillableData = $modelDTO->getFillable();

        $cssClass->fill($fillableData);

        return $cssClass;
    }
}
