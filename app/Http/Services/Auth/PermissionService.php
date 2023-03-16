<?php

namespace App\Http\Services\Auth;

use App\Http\RepoInterfaces\RepoRegisteryInterface;
use Spatie\Permission\Models\Permission;

class PermissionService
{

    private $permissionRepo;
    private  $registry;
    public function __construct(RepoRegisteryInterface $repoRegistery)
    {
        $this->registry = $repoRegistery->getInstance();
        $this->permissionRepo = $this->registry->get('permission');
    }

    public function getAllPermissions():Permission
    {
        return $this->permissionRepo->getAll();
    }

    public function getPermission($id):Permission
    {
        return $this->permissionRepo->getById($id);
    }



}
