<?php

namespace App\Http\Controllers;

use App\Http\Services\DisplayService;
use App\Http\Services\GridSettingService;
use App\Http\Services\SliderSettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DisplayController extends Controller
{
    private $displayService;

    private $sliderSettingsService;

    private $gridSettingsService;

    public function __construct(DisplayService $displayService,SliderSettingService $sliderSettingService,GridSettingService $gridSettingService)
    {
        $this->displayService = $displayService;
        $this->sliderSettingsService = $sliderSettingService;
        $this->gridSettingsService = $gridSettingService;
    }

    public function getDisplay($id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'integer|exists:displays',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $display = $this->displayService->getDisplayById($id);

        return response()->json([
            "Display"=>$display
        ]);
    }

    public function getAllDisplays() :JsonResponse
    {
        $displays = $this->displayService->getDisplays();

        return response()->json([
            "Displays"=>$displays
        ]);
    }

    public function createDisplay(Request $request):JsonResponse
    {
        /*
         * create the grid or slider first based on the type
         * then create the display with the grid or slider created
         *
         */
        $validator = Validator::make($request->all(), [
            'source_page_id' => 'required|exists:pages,id',
            'slider_settings'=>'required_if:type,slider',
            'grid_settings'=>'required_if:type,grid',
            'grid_settings.class_id'=>'integer|exists:css_classes,id',
            'slider_settings.class_id'=>'integer|exists:css_classes,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $display = $this->displayService->createDisplay($request->all());

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
        $validator = Validator::make($request->all(), [
            'grid_settings.class_id'=>'integer|exists:css_classes,id',
            'slider_settings.class_id'=>'integer|exists:css_classes,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
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

        //Scenario 1 -> Update the display itself.

       $this->displayService->updateDisplay($displayId, $userData);


        return response()->json([
            'message' => 'done',
        ]);

    }
}
//{
//     "placeholder":"display12345",
//    "type":"slider",
//    "display_template":"display_template",
//    "grid_settings_id":"5",
//    "slider_settings_id":"5",
//    "source_page_id":"1"
//}
