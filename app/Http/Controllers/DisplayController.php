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

    public function __construct(DisplayService $displayService, SliderSettingService $sliderSettingService, GridSettingService $gridSettingService)
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
            "Display" => $display
        ]);
    }

    public function getAllDisplays(): JsonResponse
    {
        $displays = $this->displayService->getDisplays();

        return response()->json([
            "Displays" => $displays
        ]);
    }

    public function createDisplay(Request $request): JsonResponse
    {
        /*
         * create the grid or slider first based on the type
         * then create the display with the grid or slider created
         *
         */
        $validator = Validator::make($request->all(), [
            'source_page_id' => 'required|exists:pages,id',
            'slider_settings' => 'required_if:type,slider',
            'grid_settings' => 'required_if:type,grid',
            'grid_settings.class_id' => 'integer|exists:css_classes,id',
            'slider_settings.class_id' => 'integer|exists:css_classes,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $display = $this->displayService->createDisplay($request->all());

        return response()->json([
            'message' => 'Display has been created successfully',
            'Display' => $display
        ], 201);
    }

    public function deleteDisplay($id): JsonResponse
    {
        $this->displayService->deleteDisplay($id);

        return response()->json([
            'message' => 'Display with ID ' . $id . ' has been deleted successfully'
        ]);
    }

    public function updateDisplay(Request $request, $displayId): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'grid_settings.class_id' => 'integer|exists:css_classes,id',
            'slider_settings.class_id' => 'integer|exists:css_classes,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $updatedDisplay = $this->displayService->updateDisplay($displayId, $request->all());


        return response()->json([
            'message' => 'Display with ID ' . $displayId . ' has been updated successfully',
            'Display' => $updatedDisplay

        ]);

    }
}
