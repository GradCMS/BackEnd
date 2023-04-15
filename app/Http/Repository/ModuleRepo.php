<?php

namespace App\Http\Repository;

use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\Module;

class ModuleRepo implements CRUDRepoInterface
{

    /**
     * @param array $modelDTO
     * @return mixed
     */
    public function create($modelDTO)
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


    public function update($id, $newData)
    {
        return Module::Query()->where($id)->update($newData);
    }
}
