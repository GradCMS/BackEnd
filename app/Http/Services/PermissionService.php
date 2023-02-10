<?php
namespace App\Http\Services;
use App\Http\Repository\PermissionRepo;
use App\Models\Permission;

class PermissionService{
    private $permissionRepo;  // dependency injection
    public function __construct(PermissionRepo $permissionRepo) // inject PageRepo or CRUDRepoInterface
    {
        return $this->permissionRepo = $permissionRepo;
    }
    public function addPermission(Permission $permission)
    {
        return $this->permissionRepo->create($permission->toArray());
    }
    public function getPermission($id)
    {
        return $this->permissionRepo->getById($id);
    }
    public function getPermissions()
    {
        return $this->permissionRepo->getAll();
    }
    public function deletePermission($id): int
    {
        return $this->permissionRepo->delete($id);
    }
    public function updatePermission($id, Permission $permission): int
    {
        return $this->permissionRepo->update($id, $permission->toArray());
    }
}
