<?php

namespace App\Http\Services;

use App\DTOs\ModelDTO;
use App\Http\RepoInterfaces\RepoRegisteryInterface;
use App\Models\CssClass;
use App\Models\Module;
use App\Traits\DTOBuilder;

class ModuleService{

    use DTOBuilder;
    private $moduleRepo;

    private $registry;

    public function __construct(RepoRegisteryInterface $ModuleRepoRegistry)
    {
        $this->registry = $ModuleRepoRegistry->getInstance();
        $this->moduleRepo = $this->registry->get('module');
    }

    public function createModule($module)
    {
        return $this->moduleRepo->create($module);
    }
    public function getModule($id)
    {
        return $this->moduleRepo->getById($id);
    }
    public function getModules()
    {
        return $this->moduleRepo->getAll();
    }
    public function deleteModule($id): int
    {
        return $this->moduleRepo->delete($id);
    }
    public function updateModule($id, $module): Module
    {
        $moduleDTO = $this->createDTO($module);

        return $this->moduleRepo->update($id, $moduleDTO);
    }

    public function createDTO($userData):ModelDTO
    {

        $fillableKeys = (new Module())->getFillable();

        $nonFillableKeys = ['id'];

        $dto = $this->buildDTO($fillableKeys, $nonFillableKeys, $userData);

        return $dto;
    }
}
