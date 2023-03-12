<?php

namespace App\Http\Services;

use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Models\Display;

class DisplayService
{
    private $displayRepo;

    public function __construct(CRUDRepoInterface $displayRepo)
    {
        $this->displayRepo = $displayRepo;
    }
    public function addDisplay(Display $display)
    {
        return $this->displayRepo->create($display->toArray());
    }
    public function getDisplay($id)
    {
        return $this->displayRepo->getById($id);
    }
    public function getDisplays()
    {
        return $this->displayRepo->getAll();
    }
    public function deleteDisplay($id): int
    {
        return $this->displayRepo->delete($id);
    }
    public function updateDisplay($id, Display $display): int
    {
        return $this->displayRepo->update($id, $display->toArray());
    }

}
