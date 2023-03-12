<?php

namespace App\Http\Repository;

use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\CssClass;

class CssClassRepo implements CRUDRepoInterface
{


    /**
     * @param array $modelDetails
     * @return mixed
     */
    public function create(array $modelDetails)
    {
        return CssClass::Query()->create($modelDetails);
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

    public function update($id, array $modelDetails)
    {
        return CssClass::Query()->where($id)->update($modelDetails);
    }
}
