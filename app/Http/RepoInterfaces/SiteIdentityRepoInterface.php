<?php

namespace App\Http\RepoInterfaces;

interface SiteIdentityRepoInterface extends CRUDRepoInterface
{
    public function getLatestRecord();
}
