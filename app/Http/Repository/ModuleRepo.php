<?php

namespace App\Http\Repository;

use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\Module;

class ModuleRepo implements CRUDRepoInterface
{

    /**
     * @param array $modelDetails
     * @return mixed
     */
    public function create($modelDetails)
    {
        return Module::Query()->create($modelDetails);
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


    public function update($id,$modelDetails)
    {
        return Module::Query()->where($id)->update($modelDetails);
    }
}
