<?php

namespace App\Http\Repository;

use App\DTOs\ModelDTO;
use App\Exceptions\MethodNotImplementedException;
use App\Models\Navbar;
use App\Models\Page;
use App\Models\SiteIdentity;

class NavbarRepo implements \App\Http\RepoInterfaces\CRUDRepoInterface
{

    public function create(ModelDTO $modelDTO): Navbar
    {
        $navBar = new Navbar();

        $navBar = $this->fillData($modelDTO, $navBar);
        $navBar->save();

        return $navBar;


    }

    public function fillData(ModelDTO $modelDTO, Navbar $navBar): Navbar
    {
        $fillableData = $modelDTO->getFillable();

        $navBar->fill($fillableData);

        return $navBar;
    }
    public function getAll(): array
    {
        $pages =  Navbar::with('children')
                    ->whereNull('parent_id')
                    ->orderBy('priority')
                    ->get();
        return $this->buildNestedElements($pages);
    }
    private function buildNestedElements($navBars): array
    {
        $result = [];

        foreach ($navBars as $navBar) {
            $nestedChildren = $this->buildNestedElements($navBar->children);

            $navBarData = [
                'id'=>$navBar->id,
                'referenced_page' => $navBar->referenced_page,
                'name' => $navBar->name,
                'priority' => $navBar->priority,
                'drop_down_elements' => $nestedChildren
            ];

            $result[] = $navBarData;
        }

        return $result;
    }

    public function getById($id)
    {
        throw new MethodNotImplementedException(__CLASS__, __FUNCTION__);
    }

    public function update($id, ModelDTO|array $newData)
    {
        $element = Navbar::find($id);
        $element = $this->fillData($newData, $element);
        $element->update();

        return $element;
    }

    public function delete($id)
    {
        Navbar::destroy($id);
    }
}
