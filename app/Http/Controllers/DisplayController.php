<?php

namespace App\Http\Controllers;

use App\Http\Services\DisplayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DisplayController extends Controller
{
    private $displayService;

    public function __construct(DisplayService $displayService)
    {
        $this->displayService = $displayService;
    }

    public function getDisplay($id): JsonResponse
    {
        $display = $this->displayService->getDisplay($id);
        return response()->json(["Display"=>$display]);
    }

    public function getDisplays() :JsonResponse
    {
        $displays = $this->displayService->getDisplays();
        return response()->json(["Displays"=>$displays]);
    }

    public function createDisplay(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'grid_settings_id' => 'required|exists:displays,id',
            'slider_settings_id' => 'required|exists:displays,id',
            'source_page_id' => 'required|exists:displays,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $userData = [
            'placeholder' => $request->input('placeholder'),
            'type'=> $request->input('type'),
            'display_template'=> $request->input('display_template'),
            'grid_settings_id'=>$request->input('grid_settings_id'),
            'slider_settings_id'=>$request->input('slider_settings_id'),
            'source_page_id'=>$request->input('source_page_id'),
        ];
        $display = $this->displayService->createDisplay($userData);

        return response()->json([
            'message'=>'Display has been created successfully',
            'Display'=>$display
        ], 201);
    }

    public function deleteDisplay($id):JsonResponse
    {
        $this->displayService->deleteDisplay($id);

        return response()->json([
            'message'=>'Display with ID '.$id.' has been deleted successfully'
        ]);
    }

    public function updateDisplay(Request $request, $displayId):JsonResponse
    {
        $userData = [
            'placeholder' => $request->input('placeholder')?? null,
            'type'=> $request->input('type')?? null,
            'display_template'=> $request->input('display_template')?? null,
            'grid_settings_id'=>$request->input('grid_settings_id')?? null,
            'slider_settings_id'=>$request->input('slider_settings_id')?? null,
            'source_page_id'=>$request->input('source_page_id')?? null,
        ];
        $userData = array_filter($userData, function ($value,$key){
            return $value !== null;
        }, ARRAY_FILTER_USE_BOTH);

        $display = $this->displayService->updateDisplay($displayId,$userData);

        return response()->json([
            'message'=>'Display with ID '.$displayId.' has been updated successfully',
            'updated_Display'=>$display
        ]);
    }
}
