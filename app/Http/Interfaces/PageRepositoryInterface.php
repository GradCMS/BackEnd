<?php

namespace App\Http\Interfaces;
use App\Models\Page;

interface PageRepositoryInterface
{
    public function getAllPages();
    public function getPageById($pageId);
    public function deletePage($pageId);
    public function createPage(Page $page);
    public function updatePage($pageId, Page $page);

}
