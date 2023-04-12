<?php

namespace App\Http\Services;

use App\DTOs\ModelDTO;
use App\Http\RepoInterfaces\RepoRegisteryInterface;
use App\Models\CssClass;
use App\Models\User;
use App\Traits\DTOBuilder;

class CssClassService
{
    use DTOBuilder;
    private $cssClassRepo;

    private $registry;

    public function __construct(RepoRegisteryInterface $cssClassRepoRegistry)
    {
        $this->registry = $cssClassRepoRegistry->getInstance();
        $this->cssClassRepo = $this->registry->get('css_class');
    }
    public function createCssClass($cssClass)
    {
        return $this->cssClassRepo->create($cssClass);
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
    public function updateCssClass($id, $cssClass): CssClass
    {
        $cssClassDTO = $this->createDTO($cssClass);

        return $this->cssClassRepo->update($id, $cssClassDTO);
    }
    public function createDTO($userData):ModelDTO
    {

        $fillableKeys = (new CssClass())->getFillable();

        $nonFillableKeys = ['id'];

        $dto = $this->buildDTO($fillableKeys, $nonFillableKeys, $userData);

        return $dto;
    }
}
