<?php
namespace App\Http\Services\Auth;
use App\Http\RepoInterfaces\RepoRegisteryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
    /**
     * creates a role and return a model instance
     * @param string $name
    */
    public function createRole(String $name)
    {
        return $this->roleRepo->create($name);
    }

    public function deleteRole($id)
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

    public function getRolewithPermissions($id)
    {
        return $this->roleRepo->getRoleWithPermissions($id);
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
