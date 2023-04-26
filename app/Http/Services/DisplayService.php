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
    private $gridSettingService;
    private $sliderSettingService;

    public function __construct(RepoRegisteryInterface $displayRepoRegistery, GridSettingService $gridSettingService, SliderSettingService $sliderSettingService)
    {
        $this->registry = $displayRepoRegistery->getInstance();
        $this->displayRepo = $this->registry->get('display');
        $this->gridSettingService = $gridSettingService;
        $this->sliderSettingService = $sliderSettingService;

    }
    public function createDisplay($displayData)
    {
       if ($displayData['type'] == 'slider'){
           $slider = $this->sliderSettingService->createSliderSetting($displayData['slider_settings']);
           $displayData['slider_settings_id'] = $slider->id;
       }
       else if ($displayData['type'] == 'grid'){
           $grid = $this->gridSettingService->createGridSetting($displayData['grid_settings']);
           $displayData['grid_settings_id'] = $grid->id;
       }

        $displayDTO = $this->createDTO($displayData);

        return $this->displayRepo->create($displayDTO);

    }

    public function getDisplayById($id)
    {
        return $this->displayRepo->getById($id);
    }
    public function getDisplays()
    {
        return $this->displayRepo->getAll();
    }
    public function deleteDisplay($id): void
    {
        $this->displayRepo->delete($id);
    }
    public function updateDisplay($id, $display): Display
    {
        $displayDTO = $this->createDTO($display);

        return $this->displayRepo->update($id, $displayDTO);
    }
    public function createDTO($displayData):ModelDTO
    {
        $fillableKeys = (new Display())->getFillable();

        return $this->buildDTO($fillableKeys, [], $displayData);

    }
}
