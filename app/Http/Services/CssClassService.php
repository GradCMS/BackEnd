<?php

namespace App\Http\Services;

use App\Http\RepoInterfaces\RepoRegisteryInterface;
use App\Models\CssClass;


class CssClassService
{
    private $cssClassRepo;

    private $registry;

    public function __construct(RepoRegisteryInterface $cssClassRepoRegistry)
    {
        $this->registry = $cssClassRepoRegistry->getInstance();
        $this->cssClassRepo = $this->registry->get('css_class');
    }
    public function createCssClass($cssClass)
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
