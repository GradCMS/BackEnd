<?php

namespace App\Http\Controllers;

use App\Http\Services\SiteIdentityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiteIdentityController extends Controller
{
    private $siteIdentityService;

    public function __construct(SiteIdentityService $siteIdentityService)
    {
        $this->siteIdentityService = $siteIdentityService;
    }

    public function createSiteIdentity(Request $request): JsonResponse
    {
        $siteIdentity = $this->siteIdentityService->createSiteIdentity($request->all());

        return response()->json([
            'message'=>'Site identity has been created successfully',
            'site identity'=>$siteIdentity
        ], 201);
    }

    public function updateSiteIdentity(Request $request, $id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:site_identities,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $siteIdentity = $this->siteIdentityService->updateSiteIdentity($request->all(), $id);

        return response()->json([
            'message'=>'Site identity with ID' .$id. ' has been updated successfully',
            'Updated_Site_Identity'=>$siteIdentity
        ]);
    }

    public function deleteSiteIdentity($id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:site_identities,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $this->siteIdentityService->deleteSiteIdentity($id);

        return response()->json([
            'message'=>'Site identity with ID '.$id.' has been deleted successfully'
        ]);
    }

    public function getSiteIdentity($id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:site_identities,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $siteIdentity = $this->siteIdentityService->getSiteIdentity($id);

        $siteIdentity = json_decode($siteIdentity, true);

        foreach ($siteIdentity as $key => $value) {
            $siteIdentity[$key] = json_decode($value);
        }

        return response()->json([
            'Site_identity'=> $siteIdentity
        ]);
    }


}
