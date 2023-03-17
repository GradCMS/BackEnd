<?php

namespace App\Http\Repository;

use App\Exceptions\MethodNotImplementedException;
use App\Http\RepoInterfaces\CRUDRepoInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

class PermissionRepo implements CRUDRepoInterface
{

    public function getAll(): Collection|array
    {
        return Permission::all();
    }

    /**
     * @param $id
     * @return Permission
     */
    public function getById($id):Permission
    {
        return Permission::findById($id);
    }
    public function create($name){

        Permission::create([
            'name'=>$name,
            'guard_name' => 'api' // in case multiple guards were used in the future
        ]);
    }

/**
 * methods that are not needed to be implemented
 * @throws MethodNotImplementedException
*/

    public function update($id, $modelDetails){
        throw new MethodNotImplementedException(__CLASS__, __FUNCTION__);
    }
    public function delete($id){
        throw new MethodNotImplementedException(__CLASS__, __FUNCTION__);
    }
}
