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

        if (!$request->has('type') && !$request->has('grid_settings') && !$request->has('slider_settings')){
            $display = $this->displayService->updateDisplay($displayId, $userData);
            return response()->json([
                'message' => 'Display with ID ' . $displayId . ' has been updated successfully',
                'updated_Display' => $display
            ]);
        }

        // Scenario 2 -> Check if the user wants to change from the grid settings to slider settings or vice versa.

        if ($request->has('grid_settings') || $request->has('slider_settings')) {

            $display = $this->displayService->getDisplayById($displayId);
            if (!$display) {
                return response()->json([
                    'message' => 'Display with ID ' . $displayId . ' does not exist'
                ], 404);
            }
            $displayType = $request->input('type');
            $gridSettings = $request->input('grid_settings');
            $sliderSettings = $request->input('slider_settings');
            if ($displayType === 'grid') {
                if ($gridSettings) {
                    // Delete existing slider settings
                    if ($display->slider_settings_id) {
                        $this->sliderSettingsService->deleteSliderSetting($display->slider_settings_id);
                    }
                    // Create new gridSettings and assign it to the display.
                    $createdGridSettings = $this->gridSettingsService->createGridSetting($gridSettings);
                    $gridSettingsId = $createdGridSettings->id;
                    $display->grid_settings_id = $gridSettingsId;
                    $display->slider_settings_id = null;
                    $display->type = 'grid';
                    $display->save();
                    return response()->json([
                        'message' => 'Display with ID ' . $displayId . ' has been updated successfully and assigned to grid settings of ' . $gridSettingsId,
                        'updated_Display' => $display
                    ]);
                }

            } elseif ($displayType === 'slider') {
                if ($sliderSettings){
                    // Delete existing grid settings
                    if ($display->grid_settings_id) {
                        $this->gridSettingsService->deleteGridSetting($display->grid_settings_id);
                    }
                    // create sliderSettings and assign it to the display
                    $createdSliderSettings = $this->sliderSettingsService->createSliderSetting($sliderSettings);
                    $sliderSettingsId = $createdSliderSettings->id;
                    $display->slider_settings_id = $sliderSettingsId;
                    $display->grid_settings_id = null;
                    $display->type = 'slider';
                    $display->save();
                    return response()->json([
                        'message' => 'Display with ID ' . $displayId . ' has been updated successfully and assigned to grid settings of ' . $sliderSettingsId,
                        'updated_Display' => $display
                    ]);
                }
            } elseif (!$request->has('type') && ($request->has('grid_settings') || $request->has('slider_settings'))) {
                $display = $this->displayService->getDisplayById($displayId);
                if ($sliderSettings) {
                    $this->sliderSettingsService->updateSliderSetting($display->slider_settings_id, $sliderSettings);
                    return response()->json([
                        'message' => 'Display with ID ' . $displayId . ' has been updated successfully and slider ' . $display->slider_settings_id .' is updated',
                        'updated_Display' => $display
                    ]);
                } elseif ($gridSettings) {
                    $this->gridSettingsService->updateGridSetting($display->grid_settings_id, $gridSettings);
                    return response()->json([
                        'message' => 'Display with ID ' . $displayId . ' has been updated successfully and grid ' . $display->grid_settings_id . ' is updated',
                        'updated_Display' => $display
                    ]);
                }
            }


        }
        return response()->json([
            'message' => 'Error'
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
