<?php

namespace App\Http\Repository;

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


    public function update($id, $newData)
    {
        return Display::Query()->where($id)->update($newData);
    }
}
