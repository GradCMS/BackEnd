<?php

namespace App\Http\RepoInterfaces;

interface PageRepoInterface extends CRUDRepoInterface
{
    public function getPagesTree();
    public function syncModulesInPage($pageId, $modules);
    public function syncDisplaysInPage($pageId, $displays);
    public function getParentPages();
    public function getStandardPages();
}
