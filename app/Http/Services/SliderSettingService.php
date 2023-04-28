<?php

namespace App\Http\Services;

use App\DTOs\ModelDTO;
use App\Http\RepoInterfaces\RepoRegisteryInterface;
use App\Models\SliderSetting;
use App\Traits\DTOBuilder;

class SliderSettingService
{
    use DTOBuilder;

    private $registry;
    private $sliderSettingRepo;

    public function __construct(RepoRegisteryInterface $repoRegistery)
    {
        $this->registry = $repoRegistery->getInstance();
        $this->sliderSettingRepo = $this->registry->get('slider_settings');

    }

    public function createSliderSetting($sliderSettingData)
    {
        $sliderSettingDTO = $this->createDTO($sliderSettingData);

        return $this->sliderSettingRepo->create($sliderSettingDTO);

    }

    public function createDTO($sliderSettingData):ModelDTO
    {
        $fillableKeys = (new SliderSetting)->getFillable();

        return $this->buildDTO($fillableKeys,[],$sliderSettingData);
    }

    public function deleteSliderSetting($id): void
    {
        $this->sliderSettingRepo->delete($id);
    }

    public function getAllSliderSettings()
    {
        return $this->sliderSettingRepo->getAll();
    }

    public function getSliderSetting($id)
    {
        return $this->sliderSettingRepo->getById($id);
    }

    public function updateSliderSetting($id, array $sliderSettingData):void
    {
        $this->sliderSettingRepo->update($id, $sliderSettingData);
    }

}
