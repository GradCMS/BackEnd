<?php

namespace App\Http\Services;

use App\Http\Repository\PageRepo;
use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\Page;

class PageService{
    private $pageRepo;  // dependency injection
    public function __construct(PageRepo $pageRepo) // inject PageRepo or CRUDRepoInterface
    {
       return $this->pageRepo = $pageRepo;
    }
    public function addPage(Page $page)
    {
        return $this->pageRepo->create($page->toArray());
    }
    public function getPage($id)
    {
        return $this->pageRepo->getById($id);
    }
    public function getPages()
    {
        return $this->pageRepo->getAll();
    }
    public function deletePage($id): int
    {
        return $this->pageRepo->delete($id);
    }
    public function updatePage($id, Page $page): int
    {
        return $this->pageRepo->update($id, $page->toArray());
    }
    public function addPermissionToUser(){
        // user
        // validate ano 3ando 22 sana

        // permsion
        // assign permisison to user
    }

}
