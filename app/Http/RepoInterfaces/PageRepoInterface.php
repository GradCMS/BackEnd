<?php

namespace App\Http\RepoInterfaces;

interface PageRepoInterface extends CRUDRepoInterface
{
    public function getPagesTree();
}
