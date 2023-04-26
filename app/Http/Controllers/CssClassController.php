<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Services\CssClassService;
class CssClassController extends Controller
{
    private $cssClassService;
    public function __construct(CssClassService $cssClassService)
    {
        $this->cssClassService = $cssClassService;
    }

    public function getCssClass($id): JsonResponse
    {
        $cssClass = $this->cssClassService->getCssClass($id);
        return response()->json(["CssClass"=>$cssClass]);
    }

    public function getCssClasses() :JsonResponse
    {
        $cssClasses = $this->cssClassService->getCssClasses();
        return response()->json(["cssClasses"=>$cssClasses]);
    }

    public function createCssClass(Request $request):JsonResponse
    {
        $userData = [
            'placeholder' => $request->input('placeholder'),
            'tags'=> $request->input('tags'),
            'reference_name'=> $request->input('reference_name'),
            'json'=>$request->input('json'),
            'css'=>$request->input('css'),
            'custom_css'=>$request->input('custom_css'),
        ];
        $cssClass = $this->cssClassService->createCssClass($userData);

        return response()->json([
            'message'=>'CssClass has been created successfully',
            'CssClass'=>$cssClass
        ], 201);
    }

    public function deleteCssClass($id):JsonResponse
    {
        $this->cssClassService->deleteCssClass($id);

        return response()->json([
            'message'=>'CssClass with ID '.$id.' has been deleted successfully'
        ]);
    }

    public function updateCssClass(Request $request,$cssClassId):JsonResponse
    {
        $userData = [
            'placeholder' => $request->input('placeholder') ?? null,
            'tags'=> $request->input('tags')?? null,
            'reference_name'=> $request->input('reference_name')?? null,
            'json'=>$request->input('json')?? null,
            'css'=>$request->input('css')?? null,
            'custom_css'=>$request->input('custom_css')?? null,
        ];
        $userData = array_filter($userData, function ($value,$key){
            return $value !== null;
        }, ARRAY_FILTER_USE_BOTH);

        $cssClass = $this->cssClassService->updateCssClass($cssClassId,$userData);

        return response()->json([
            'message'=>'CssClass with ID '.$cssClassId.' has been updated successfully',
            'updated_CssClass'=>$cssClass
        ]);
    }

}
