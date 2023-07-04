<?php

namespace App\Http\Repository;

use App\DTOs\ModelDTO;
use App\Exceptions\MethodNotImplementedException;
use App\Http\RepoInterfaces\CRUDRepoInterface;
use App\Http\RepoInterfaces\SiteIdentityRepoInterface;
use App\Http\Services\SiteIdentityService;
use App\Models\Page;
use App\Models\SiteIdentity;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\String\s;

class SiteIdentityRepo implements SiteIdentityRepoInterface
{

    public function create(ModelDTO $modelDTO):SiteIdentity
    {
        $siteIdentity = new SiteIdentity();

        $siteIdentity = $this->fillData($modelDTO, $siteIdentity);
        $siteIdentity->save();

        return $siteIdentity;
    }

    public function fillData(ModelDTO $modelDTO, SiteIdentity $siteIdentity): SiteIdentity
    {
        $fillableData = $modelDTO->getFillable();

        $siteIdentity->fill($fillableData);

        return $siteIdentity;
    }


    public function getById($id)
    {
        return SiteIdentity::find($id);
    }


    public function update($id, ModelDTO|array $newData): SiteIdentity
    {
        $siteIdentity = SiteIdentity::find($id);

        $siteIdentity = $this->fillData($newData,$siteIdentity);

        $siteIdentity->update();

        return $siteIdentity;
    }


    public function delete($id)
    {
        SiteIdentity::destroy($id);
    }

    public function getAll()
    {
        throw new MethodNotImplementedException(__CLASS__, __FUNCTION__);
    }

    public function getLatestRecord()
    {
        return SiteIdentity::latest()->first();
    }
}
