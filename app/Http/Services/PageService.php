<?php

namespace App\Http\Services;

use App\DTOs\ModelDTO;
use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Http\RepoInterfaces\RepoRegisteryInterface;
use App\Models\Page;
use App\Traits\DTOBuilder;

class PageService{

    use DTOBuilder;
    private $registry;
    private $pageRepo;
    public function __construct(RepoRegisteryInterface $repoRegistery)
    {
        $this->registry = $repoRegistery->getInstance();
        $this->pageRepo = $this->registry->get('page');
    }
    public function createPage($pageData)
    {
        $pageDTO = $this->createDTO($pageData);

        return $this->pageRepo->create($pageDTO);
    }

    public function createDTO($pageData): ModelDTO
    {
        $fillableKeys = (new Page)->getFillable();
        return $this->buildDTO($fillableKeys, [], $pageData);
    }
    public function getPagesTree()
    {
        return $this->pageRepo->getPagesTree();

    }

    public function updatePage($id, array $pageData): void
    {
        $this->pageRepo->update($id, $pageData);
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


}
