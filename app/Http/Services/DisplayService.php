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
        $this->gridSettingsService = $gridSettingsService;
        $this->sliderSettingsService = $sliderSettingsService;

    }
    public function createDisplay($displayData)
    {
       if ($displayData['type'] == 'slider'){
           $slider = $this->sliderSettingsService->createSliderSetting($displayData['slider_setting']);
           $displayData['slider_settings_id'] = $slider->id;
       }
       else if ($displayData['type'] == 'grid'){
           $grid = $this->gridSettingsService->createGridSetting($displayData['grid_setting']);
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
        /** algorithm:
         *
         * get display with $id (it will come with either gridSettingsId or sliderSettingsId)
         *  this step tells us weather the display is grid or slider
         *
         * update display like normal, pass all the data coming from the request
         * (we have the old display , we know if it's slider or grid , and we have the object {id} of the slider or grid)
         *
         * conditions (scenarios):
         *      if the old display is slider and the $displayData.isset(sliderSettings)
         *          this means we want to update the slider settings, so we will call the update slider settings from the service
         *
         *      the same condition for grid update grid settings (grid, grid)
         *
         *      if old display is grid and the $displayData.isset(sliderSettings)
         *          this means we want to update the type of display and delete the grid settings reference (set to null)
         *          then create new slider settings and put the reference in the new updated display (grid to slider)
         *
         *         the same condition for slider to grid
         *
        */

        $display = $this->displayRepo->getById($id);

        //Scenario 1 -> Update slider settings//grid settings.

        if ($display->slider_settings_id!=null && array_key_exists('slider_setting',$displayData))//Update slider data
        {
            $this->sliderSettingsService->updateSliderSetting($display->slider_settings_id,$displayData['slider_setting']);
        }
        elseif ($display->grid_settings_id!=null && array_key_exists('grid_setting',$displayData))
        {
            $this->gridSettingsService->updategridSetting($display->grid_settings_id,$displayData['grid_setting']);
        }

        // Scenario 2 -> Check if the user wants to change from the grid settings to slider settings or vice versa.

        elseif($display->slider_settings_id!=null && array_key_exists('grid_setting',$displayData))
        {
            $this->sliderSettingsService->deleteSliderSetting($display->slider_settings_id);
            $newGridSettings = $this->gridSettingsService->createGridSetting($displayData['grid_setting']);
            $displayData['grid_settings_id'] = $newGridSettings->id;
        }
        elseif($display->grid_settings_id!=null && array_key_exists('slider_setting',$displayData))
        {
            $this->gridSettingsService->deleteGridSetting($display->grid_settings_id);
            $newSliderSettings = $this->sliderSettingsService->createSliderSetting($displayData['slider_setting']);
            $displayData['slider_settings_id'] = $newSliderSettings->id;
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
