<?php

namespace App\Http\Repository;

use App\DTOs\ModelDTO;
use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\Module;

class ModuleRepo implements CRUDRepoInterface
{

    /**
     * @param array $modelDTO
     * @return mixed
     */
    public function create($modelDTO): mixed
    {
        return Module::Query()->create($modelDTO);
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return Module::all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return Module::Query()->findOrFail($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return Module::destroy($id);
    }


    public function update($id, ModelDTO|array $modelDetails):Module
    {
        $module = Module::findOrFail($id);

        $module = $this->fillData($modelDetails,$module);

        $module->update();

        return $module;
    }
    public function fillData($modelDTO, Module $module): Module
    {
        $fillableData = $modelDTO->getFillable();

        $module->fill($fillableData);

        return $module;
    }

}
