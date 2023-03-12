<?php

namespace App\Http\Services;

use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\Module;

class ModuleService{
    private $moduleRepo;

    public function __construct(CRUDRepoInterface $moduleRepo)
    {
        $this->moduleRepo = $moduleRepo;
    }

    public function addModule(Module $module)
    {
        return $this->moduleRepo->create($module->toArray());
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
    public function updateModule($id, Module $module): int
    {
        return $this->moduleRepo->update($id, $module->toArray());
    }
}
