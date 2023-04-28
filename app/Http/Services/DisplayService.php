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

    private $sliderSettingsRepo;

    private $gridSettingsRepo;

    private $registry;
    private $gridSettingsService;
    private $sliderSettingsService;

    public function __construct(RepoRegisteryInterface $displayRepoRegistery, GridSettingService $gridSettingsService, SliderSettingService $sliderSettingsService)
    {
        $this->registry = $displayRepoRegistery->getInstance();
        $this->displayRepo = $this->registry->get('display');
        $this->sliderSettingsRepo = $this->registry->get('slider_settings');
        $this->gridSettingsRepo = $this->registry->get('grid_settings');
        $this->gridSettingsService = $gridSettingsService;
        $this->sliderSettingsService = $sliderSettingsService;

    }
    public function createDisplay($displayData)
    {
       if ($displayData['type'] == 'slider'){
           $slider = $this->sliderSettingsService->createSliderSetting($displayData['slider_settings']);
           $displayData['slider_settings_id'] = $slider->id;
       }
       else if ($displayData['type'] == 'grid'){
           $grid = $this->gridSettingsService->createGridSetting($displayData['grid_settings']);
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
    public function updateDisplay($id, $displayData): Display
    {
        //Scenario 1 -> Update the display itself.
        if (!array_key_exists('type', $displayData) && !array_key_exists('grid_settings', $displayData) && !array_key_exists('slider_settings', $displayData)){
            $displayDTO = $this->createDTO($displayData);
            return $this->displayRepo->update($id, $displayDTO);
        }

        // Scenario 2 -> Check if the user wants to change from the grid settings to slider settings or vice versa.

        if(array_key_exists('type', $displayData) && array_key_exists('grid_settings', $displayData) || array_key_exists('slider_settings', $displayData)) {
            $display = $this->displayRepo->getById($id);
            if (array_key_exists('type', $displayData) && $displayData['type']==='grid') {
                if (array_key_exists('grid_settings', $displayData)) {
                    // Delete existing slider settings
                    if ($display->slider_settings_id) {
                        $this->sliderSettingsRepo->delete($display->slider_settings_id);
                    }
                    // Create new gridSettings and assign it to the display.
                    $gridSettingsDTO = $this->gridSettingsService->createDTO($displayData['grid_settings']);
                    $createdGridSettings = $this->gridSettingsRepo->create($gridSettingsDTO);
                    $displayData['grid_settings_id'] = $createdGridSettings->id;
                    $displayData['slider_settings_id']->slider_settings_id = null;
                    $displayData['type'] = 'grid';
                }
            }
            if (array_key_exists('type', $displayData) && $displayData['type']==='slider') {
                $display = $this->displayRepo->getById($id);
                if (array_key_exists('slider_settings', $displayData)) {
                    // Delete existing grid settings
                    if ($display->grid_settings_id) {
                        $this->gridSettingsRepo->delete($display->grid_settings_id);
                    }
                    // Create new sliderSettings and assign it to the display.
                    $gridSettingsDTO = $this->sliderSettingsService->createDTO($displayData['grid_settings']);
                    $createdGridSettings = $this->gridSettingsRepo->create($gridSettingsDTO);
                    $displayData['grid_settings_id'] = $createdGridSettings->id;
                    $displayData['slider_settings_id']->slider_settings_id = null;
                    $displayData['type'] = 'grid';
                }
            }
        }if (!array_key_exists('type', $displayData) && array_key_exists('grid_settings', $displayData) || array_key_exists('slider_settings', $displayData)){
            $display = $this->displayRepo->getById($id);
            if (array_key_exists('slider_settings', $displayData)){
                $sliderId = $display['slider_settings_id'];
                $sliderDTO = $this->sliderSettingsService->createDTO($displayData['slider_settings']);
                $this->sliderSettingsRepo->update($sliderId,$sliderDTO);
            }elseif (array_key_exists('grid_settings', $displayData)){
                $gridId = $display['slider_settings_id'];
                $gridDTO = $this->gridSettingsService->createDTO($displayData['grid_settings']);
                $this->gridSettingsRepo->update($gridId,$gridDTO);
            }
        }

        $displayDTO = $this->createDTO($displayData);

        return $this->displayRepo->update($id, $displayDTO);
    }
    public function createDTO($displayData):ModelDTO
    {

        $fillableKeys = (new Display())->getFillable();

        return $this->buildDTO($fillableKeys, [], $displayData);

    }
}
