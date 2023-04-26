<?php

namespace App\Http\Services;

use App\DTOs\ModelDTO;
use App\Http\RepoInterfaces\RepoRegisteryInterface;
use App\Models\GridSetting;
use App\Traits\DTOBuilder;

class GridSettingService
{
    use DTOBuilder;

    private $registry;
    private $gridSettingRepo;

    public function __construct(RepoRegisteryInterface $repoRegistery)
    {
        $this->registry = $repoRegistery->getInstance();
        $this->gridSettingRepo = $this->registry->get('grid_settings');

    }

    public function createGridSetting($gridSettingData)
    {
        $gridsettingDTO = $this->createDTO($gridSettingData);

        return $this->gridSettingRepo->create($gridsettingDTO);
    }

    public function createDTO($gridSettingData):ModelDTO
    {
        $fillableKeys = (new GridSetting)->getFillable();

        return $this->buildDTO($fillableKeys,[],$gridSettingData);
    }

    public function deleteGridSetting($id): void
    {
        $this->gridSettingRepo->delete($id);
    }

    public function getAllGridSettings()
    {
        return $this->gridSettingRepo->getAll();
    }

    public function getGridSetting($id)
    {
        return $this->gridSettingRepo->getById($id);
    }

    public function updateGridSetting($id, array $gridSettingData):void
    {
        $this->gridSettingRepo->update($id, $gridSettingData);
    }




}
