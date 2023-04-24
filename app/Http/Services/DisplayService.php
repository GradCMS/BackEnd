<?php

namespace App\Http\Services;

use App\DTOs\ModelDTO;
use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Http\RepoInterfaces\RepoRegisteryInterface;
use App\Models\Display;
use App\Traits\DTOBuilder;

class DisplayService
{
    use DTOBuilder;
    private $displayRepo;

    private $registry;


    public function __construct(RepoRegisteryInterface $displayRepoRegistery)
    {
        $this->registry = $displayRepoRegistery->getInstance();
        $this->displayRepo = $this->registry->get('display');
    }
    public function createDisplay( $display)
    {
        return $this->displayRepo->create($display);
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
    public function updateDisplay($id, $display): Display
    {
        $displayDTO = $this->createDTO($display);

        return $this->displayRepo->update($id, $displayDTO);
    }
    public function createDTO($userData):ModelDTO
    {
        $fillableKeys = (new Display())->getFillable();

        $nonFillableKeys = ['id'];

        $dto = $this->buildDTO($fillableKeys, $nonFillableKeys, $userData);

        return $dto;

    }
}
