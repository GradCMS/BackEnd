<?php

namespace App\Http\Services;

use App\DTOs\ModelDTO;
use App\Http\RepoInterfaces\RepoRegisteryInterface;
use App\Models\Navbar;
use App\Models\Page;
use App\Traits\DTOBuilder;

class NavBarService
{

    use DTOBuilder;
    private $registry;
    private $navBarRepo;
    public function __construct(RepoRegisteryInterface $repoRegistery)
    {
        $this->registry = $repoRegistery->getInstance();
        $this->navBarRepo = $this->registry->get('nav_bar');
    }

    public function addElement($navBarData)
    {
        $navBarDTO = $this->createDTO($navBarData);

        return $this->navBarRepo->create($navBarDTO);
    }

    public function createDTO($navBarData): ModelDTO
    {
        $fillableKeys = (new Navbar())->getFillable();
        return $this->buildDTO($fillableKeys, [], $navBarData);
    }

    public function getNavBar()
    {
        return $this->navBarRepo->getAll();
    }

    public function deleteElement($id): void
    {
        $this->navBarRepo->delete($id);
    }

    public function updateElement($id, $data)
    {
        $navBarDTO = $this->createDTO($data);
        return $this->navBarRepo->update($id, $navBarDTO);

    }
}
