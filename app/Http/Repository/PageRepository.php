<?php
namespace App\Http\Repository;

use App\Http\interfaces\PageRepositoryInterface;
use App\Models\Page;

class PageRepository implements PageRepositoryInterface{

    public function getAllPages()
    {
        // TODO: Implement getAllPages() method.
        return Page::all();
    }

    public function getPageById($pageId)
    {
        // TODO: Implement getPageById() method.
        return Page::findOrFail($pageId);
    }

    public function deletePage($pageId)
    {
        // TODO: Implement deletePageById() method.
        return Page::destroy($pageId);
    }

    public function createPage(Page $page)
    {
        // TODO: Implement createPage() method.
        return Page::create($page);
    }

    public function updatePage($pageId, Page $page)
    {
        // TODO: Implement updatePage() method.
        return Page::whereId($pageId)->update($page);
    }
}
