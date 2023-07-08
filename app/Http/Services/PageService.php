<?php

namespace App\Http\Services;

use App\DTOs\ModelDTO;
use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Http\RepoInterfaces\RepoRegisteryInterface;
use App\Models\Page;
use App\Traits\DTOBuilder;
use App\Traits\UploadImage;

class PageService{

    use DTOBuilder;
    use UploadImage;

    private $registry;
    private $pageRepo;
    public function __construct(RepoRegisteryInterface $repoRegistery)
    {
        $this->registry = $repoRegistery->getInstance();
        $this->pageRepo = $this->registry->get('page');
    }
    public function createPage($pageData)
    {
        $pageData = $this->uploadPageImages($pageData);
        $pageDTO = $this->createDTO($pageData);

        return $this->pageRepo->create($pageDTO);
    }

    public function createDTO($pageData): ModelDTO
    {
        $fillableKeys = (new Page)->getFillable();
        return $this->buildDTO($fillableKeys, [], $pageData);
    }
    public function uploadPageImages($pageData)
    {
        if(array_key_exists('header_image_url', $pageData))
        {
            $pageData['header_image_url'] = $this->uploadImage($pageData['header_image_url']);
        }
        if(array_key_exists('cover_image_url', $pageData))
        {
            $pageData['cover_image_url'] = $this->uploadImage($pageData['cover_image_url']);
        }
        return $pageData;
    }
    public function getPagesTree()
    {
        return $this->pageRepo->getPagesTree();
    }

    public function updatePage($id, $pageData): void
    {
        $pageData = $this->uploadPageImages($pageData);
        $pageDTO = $this->createDTO($pageData);

        if(array_key_exists('modules', $pageData))
        {
            $this->syncModules($id, $pageData['modules']);
        }
        if(array_key_exists('page_displays', $pageData))
        {
            $this->syncDisplays($id, $pageData['page_displays']);
        }

        $this->pageRepo->update($id, $pageDTO);
    }

    public function getAllPages()
    {
       return $this->pageRepo->getAll();
    }

    public function getPageById($id)
    {
        return $this->pageRepo->getById($id);
    }

    public function deletePage($id): void
    {
        $this->pageRepo->delete($id);
    }

    public function syncModules($pageID, $modules): void
    {
        $moduleArray=[];

        foreach ($modules as $moduleData)
        {
            $moduleArray[$moduleData['id']] = ['priority' => $moduleData['priority']];
        }

        $this->pageRepo->syncModulesInPage($pageID, $moduleArray);

    }


    public function syncDisplays($pageID, $displays): void
    {
        $displayArray=[];

        foreach ($displays as $displayData)
        {
            $displayArray[$displayData['id']] = ['priority' => $displayData['priority']];
        }

        $this->pageRepo->syncDisplaysInPage($pageID, $displayArray);

    }
    public function getParentPages()
    {
        return $this->pageRepo->getParentPages();
    }

    public function getStandardPages()
    {
        return $this->pageRepo->getStandardPages();
    }

    public function getPageChildren($id)
    {
        return $this->pageRepo->getPageChildren($id);
    }


}
