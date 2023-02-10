<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\PageService;

class PageController extends Controller // controllers handles all the requests
{
    private $pageService;  // check is this worth the dependency inj.?
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }
    public function getPage($id=null)
    {
       return $id?$this->pageService->getPage($id):$this->pageService->getPages();
    }


}
