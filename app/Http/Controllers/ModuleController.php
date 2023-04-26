<?php

namespace App\Http\Controllers;

use App\Http\Services\ModuleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    private $moduleService;

    public function __construct(ModuleService $moduleService)
    {
        $this->moduleService = $moduleService;
    }

    public function getModule($id): JsonResponse
    {
        $module = $this->moduleService->getModule($id);
        return response()->json(["Module"=>$module]);
    }

    public function getModules() :JsonResponse
    {
        $modules = $this->moduleService->getModules();
        return response()->json(["modules"=>$modules]);
    }

    public function createModule(Request $request):JsonResponse
    {
        $userData = [
            'placeholder' => $request->input('placeholder'),
            'animation_style'=> $request->input('animation_style'),
            'title'=> $request->input('title'),
            'subtitle'=>$request->input('subtitle'),
            'class_id'=>$request->input('class_id'),
            'content'=>$request->input('content'),
            'width'=>$request->input('width'),
        ];
        $module = $this->moduleService->createModule($userData);

        return response()->json([
            'message'=>'Module has been created successfully',
            'user'=>$module
        ], 201);
    }

    public function deleteModule($id):JsonResponse
    {
        $this->moduleService->deleteModule($id);

        return response()->json([
            'message'=>'Module with ID '.$id.' has been deleted successfully'
        ]);
    }

    public function updateModule(Request $request, $moduleID):JsonResponse
    {
        $userData = [
            'placeholder' => $request->input('placeholder') ?? null,
            'animation_style'=> $request->input('animation_style')?? null,
            'title'=> $request->input('title')?? null,
            'subtitle'=>$request->input('subtitle')?? null,
            'class_id'=>$request->input('class_id')?? null,
            'content'=>$request->input('content')?? null,
            'width'=>$request->input('width')?? null,
        ];
        $userData = array_filter($userData, function ($value,$key){
            return $value !== null;
        }, ARRAY_FILTER_USE_BOTH);

        $module = $this->moduleService->updateModule($moduleID,$userData);

        return response()->json([
            'message'=>'Module with ID '.$moduleID.' has been updated successfully',
            'updated_Module'=>$module
        ]);
    }
}
