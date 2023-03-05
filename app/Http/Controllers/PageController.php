<?php

namespace App\Http\Controllers;

use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Http\Repository\PageRepo;
use App\Http\Repository\PermissionRepo;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PageController extends Controller // controllers handles all the requests
{
    private $pageRepo;
    public function __construct(CRUDRepoInterface $CRUDRepo)
    {

        $this->pageRepo = $CRUDRepo;
    }
    public function getPage($id=null)  // GET
    {
        return $id?$this->pageRepo->getById($id):$this->pageRepo->getAll();
    }
    public function addPage(Page $page) // POST
    {
        // handle the request object
        return $this->pageRepo->create($page->toArray());
    }
    public function deletePage($id): int  // POST or DELETE
    {
        return $this->pageRepo->delete($id);
    }
    public function updatePage($id, Page $page): int  //POST
    {
        // handle request
        return $this->pageRepo->update($id, $page->toArray());
    }

}
