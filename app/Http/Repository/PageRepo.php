<?php
namespace App\Http\Repository;

use App\DTOs\ModelDTO;
use App\Http\RepoInterfaces\PageRepoInterface;
use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
/**
 * Post
 *
 * @mixin Builder
 */
class PageRepo implements PageRepoInterface
{

    public function create(ModelDTO $modelDTO):Page
    {
        $page = new Page();

        $page = $this->fillData($modelDTO, $page);
        $page->save();

        return $page;
    }

    public function fillData(ModelDTO $modelDTO, Page $page): Page
    {
        $fillableData = $modelDTO->getFillable();
        $page->fill($fillableData);
        return $page;
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection|array
    {
        $pages = Page::with(['modules' => function ($query) {
            $query->select()
                  ->withPivot('priority');
        },
            'pageDisplays'=>function($query){
            $query->select()
                  ->withPivot('priority');
            }])->get();

        foreach ($pages as $page){
            $page->modules->each(function ($module) {
                $module->makeHidden(['pivot', 'page_id', 'module_id']);
            });

            $page->pageDisplays->each(function ($display) {
                $display->makeHidden(['pivot', 'page_id', 'display_id']);
            });
        }


        return $pages;
    }


    public function getById($id)
    {
        $page = Page::with(['modules' => function ($query) {
            $query->select()
                ->withPivot('priority');
        },
            'pageDisplays'=>function($query){
                $query->select()
                    ->withPivot('priority');
            }])->find($id);

        $page->modules->each(function ($module) {
            $module->makeHidden(['pivot', 'page_id', 'module_id']);
        });

        $page->pageDisplays->each(function ($display) {
            $display->makeHidden(['pivot', 'page_id', 'display_id']);
        });

        return $page;
    }


    public function update($id, ModelDTO|array $newData)
    { // passing array as it's simple update
        $page = Page::find($id);

        $page->update($newData);
    }


    public function delete($id)
    {
        Page::destroy($id);
    }

    public function getPagesTree(): array
    {
        $pages =  Page::with('children')
                        ->whereNull('parent_id')
                        ->orderBy('id')
                        ->get();
        return $this->buildNestedPages($pages);
    }

    private function buildNestedPages($pages): array
    {
        $result = [];

        foreach ($pages as $page) {
            $nestedChildren = $this->buildNestedPages($page->children);

            $pageData = [
                'id' => $page->id,
                'title' => $page->title,
                'children' => $nestedChildren
            ];

            $result[] = $pageData;
        }

        return $result;
    }

    public function syncModulesInPage($pageId, $modules)
    {
        $page = Page::find($pageId);

        $page->modules()->sync($modules);
    }

    public function syncDisplaysInPage($pageId, $displays)
    {
        $page = Page::find($pageId);

        $page->pageDisplays()->sync($displays);
    }

    /**
     * @return array
     */
    public function getParentPages(): array
    {
        $pages = array();
        $uniqeParentIds =  Page::distinct()->whereNotNull('parent_id')->pluck('parent_id');

        $parentPages = Page::whereIn('id',$uniqeParentIds)->get();

        foreach ($parentPages as $page)
        {
            $info = ["id"=>$page->id, "title"=>$page->title];
            $pages[] = $info;
        }
        return $pages;
    }
}
