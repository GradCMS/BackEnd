<?php

namespace App\Http\Repository;

use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\Display;

class DisplayRepo implements CRUDRepoInterface
{


    /**
     * @param array $modelDetails
     * @return mixed
     */
    public function create($modelDetails)
    {
        return Display::Query()->create($modelDetails);
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


    public function update($id, $modelDetails)
    {
        return Display::Query()->where($id)->update($modelDetails);
    }
}
