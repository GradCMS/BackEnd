<?php

namespace App\Http\Services;

use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\CssClass;

class CssClassService
{
    private $cssClassRepo;

    public function __construct(CRUDRepoInterface $cssClassRepo)
    {
        $this->cssClassRepo = $cssClassRepo;
    }
    public function addCssClass(CssClass $cssClass)
    {
        return $this->cssClassRepo->create($cssClass->toArray());
    }
    public function getCssClass($id)
    {
        return $this->cssClassRepo->getById($id);
    }
    public function getCssClasses()
    {
        return $this->cssClassRepo->getAll();
    }
    public function deleteCssClass($id): int
    {
        return $this->cssClassRepo->delete($id);
    }
    public function updateCssClass($id, CssClass $cssClass): int
    {
        return $this->cssClassRepo->update($id, $cssClass->toArray());
    }
}
