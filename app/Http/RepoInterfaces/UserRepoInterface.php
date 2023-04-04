<?php

namespace App\Http\RepoInterfaces;

interface UserRepoInterface extends CRUDRepoInterface
{
    public function suspendUser($id);
    public function unsuspendUser($id);
    public function getSuspendedUsers();

}
