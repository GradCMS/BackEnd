<?php

namespace App\Http\RepoInterfaces;

interface RoleInterface extends CRUDRepoInterface
{
    public function getRolesWithPermissions();
    public function getRoleWithPermissions($id);

}
