<?php

namespace App\Http\Services;

use App\DTOs\ModelDTO;
use App\Http\RepoInterfaces\RepoRegisteryInterface;
use App\Models\SiteIdentity;
use App\Traits\DTOBuilder;
use App\Traits\UploadImage;

class SiteIdentityService
{
    use DTOBuilder;
    use UploadImage;

    private $registry;
    private $siteIdentityRepo;
    public function __construct(RepoRegisteryInterface $repoRegistery)
    {
        $this->registry = $repoRegistery->getInstance();
        $this->siteIdentityRepo = $this->registry->get('site_identity');
    }

    public function createSiteIdentity($siteIdentityData)
    {
        $siteIdentityData = $this->uploadImages($siteIdentityData);
        $siteIdentityDTO = $this->createDTO($siteIdentityData);

        foreach ($siteIdentityDTO->getFillable() as $key => $value) {
            $siteIdentityDTO->fill[$key] = json_encode($value);
        }
       return $this->siteIdentityRepo->create($siteIdentityDTO);
    }

    public function uploadImages($siteIdentityData) // upload images for site identity
    {
        if (array_key_exists('images', $siteIdentityData)) {
            foreach ($siteIdentityData['images'] as $key => $image) {
                $siteIdentityData['images'][$key] = $this->uploadImage($image);
            }
        }
        return $siteIdentityData;
    }
    public function createDTO($siteIdentityData):ModelDTO
    {
        $fillableKeys = (new SiteIdentity)->getFillable();
        return $this->buildDTO($fillableKeys, [], $siteIdentityData);
    }

    public function updateSiteIdentity($siteIdentityData, $id)
    {
        $siteIdentityData = $this->uploadImages($siteIdentityData);
        $siteIdentityDTO = $this->createDTO($siteIdentityData);

        foreach ($siteIdentityDTO->getFillable() as $key => $value) {
            $siteIdentityDTO->fill[$key] = json_encode($value);
        }

        return $this->siteIdentityRepo->update($id, $siteIdentityDTO);
    }

    public function deleteSiteIdentity($id): void
    {
        $this->siteIdentityRepo->delete($id);
    }

    public function getSiteIdentity($id)
    {
        return $this->siteIdentityRepo->getById($id);
    }

}
