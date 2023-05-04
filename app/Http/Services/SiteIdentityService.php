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
        if(array_key_exists('images', $siteIdentityData))
        {
            $siteIdentityData['images'] = $this->uploadImages($siteIdentityData['images']);
        }
        $siteIdentityDTO = $this->createDTO($siteIdentityData);

        foreach ($siteIdentityDTO->getFillable() as $key => $value) {
            $siteIdentityDTO->fill[$key] = json_encode($value);
        }
       return $this->siteIdentityRepo->create($siteIdentityDTO);
    }

    public function uploadImages($images) // upload images for site identity
    {
        foreach ($images as $key => $image){
           $images[$key] =  $this->uploadImage($image);
        }
        return $images;
    }

    public function createDTO($siteIdentityData):ModelDTO
    {
        $fillableKeys = (new SiteIdentity)->getFillable();
        return $this->buildDTO($fillableKeys, [], $siteIdentityData);
    }

    public function updateSiteIdentity($siteIdentityData, $id)
    {
        $siteIdentityDTO = $this->createDTO($siteIdentityData);

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
