<?php

namespace App\Http\Services;

use App\DTOs\ModelDTO;
use App\Http\RepoInterfaces\RepoRegisteryInterface;
use App\Models\SiteIdentity;
use App\Traits\DTOBuilder;

class SiteIdentityService
{
    use DTOBuilder;

    private $registry;
    private $siteIdentityRepo;
    public function __construct(RepoRegisteryInterface $repoRegistery)
    {
        $this->registry = $repoRegistery->getInstance();
        $this->siteIdentityRepo = $this->registry->get('site_identity');
    }

    public function createSiteIdentity($siteIdentityData)
    {
        $siteIdentityDTO = $this->createDTO($siteIdentityData);

       return $this->siteIdentityRepo->create($siteIdentityDTO);
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
