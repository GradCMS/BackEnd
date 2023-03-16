<?php
namespace App\Http\Services\Auth;
use App\Http\RepoInterfaces\RepoRegisteryInterface;
use Spatie\Permission\Models\Role;

class RoleService{

    private $roleRepo;
    private $permissionRepo;
    private  $registry;
    public function __construct(RepoRegisteryInterface $repoRegistery)
    {
        $this->registry = $repoRegistery->getInstance();
        $this->roleRepo = $this->registry->get('role');
        $this->permissionRepo = $this->registry->get('permission');
    }

    public function createRole(String $name): void
    {
        $this->roleRepo->create($name);
    }

    public function deleteRole($id): void
    {
        $this->roleRepo->delete($id);
    }
    public function updatePermissionsInRole($id, $newPermissions): void
    {
        $this->roleRepo->update($id, $newPermissions);
    }
    public function getRole($id):Role
    {
        return $this->roleRepo->getById($id);
    }

    public function getAllRoles():Role
    {
        return $this->roleRepo->getAll();
    }

    public function getRolesWithPermissions()
    {
        return $this->roleRepo->getRolesWithPermissions();
    }

    public function getPermissionsOfRole($id)
    {
        return $this->roleRepo->getPermissionsOfRole($id);
    }


////////////////////////////////
    public function addPermissionToRole($roleId, $permissionId):void
    {
        $role = $this->roleRepo->getById($roleId);
        $permission =$this->permissionRepo->getById($permissionId);
        $role->givePermissionTo($permission);
    }
    public function revokePermissionFromRole($roleId, $permissionId):void
    {
        $role = $this->roleRepo->getById($roleId);
        $permission =$this->permissionRepo->getById($permissionId);
        $role->revokePermissionTo($permission);
    }


}
