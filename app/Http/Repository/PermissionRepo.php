<?php

namespace App\Http\Repository;

use App\Exceptions\MethodNotImplementedException;
use App\Http\RepoInterfaces\CRUDRepoInterface;
use Spatie\Permission\Models\Permission;

class PermissionRepo implements CRUDRepoInterface
{
    /**
     * @return Permission[]
     */
    public function getAll(): array
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

/**
 * methods that are not needed to be implemented
 * @throws MethodNotImplementedException
*/
    public function create($modelDetails){
        throw new MethodNotImplementedException(__CLASS__, __FUNCTION__);
    }
    public function update($id, $modelDetails){
        throw new MethodNotImplementedException(__CLASS__, __FUNCTION__);
    }
    public function delete($id){
        throw new MethodNotImplementedException(__CLASS__, __FUNCTION__);
    }
}
