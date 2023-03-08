<?php

namespace App\Http\Controllers;

use App\Models\Display;
use App\Models\GridSetting;
use App\Models\SliderSetting;
use Illuminate\Database\Eloquent\Builder;
use App\Models\CssClass;
use App\Models\Module;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\AssignOp\Mod;

class test extends Controller
{
    public function createPage(Request $request): JsonResponse
    {
        $data = [
            'type'=> $request->input('type'),
            'title'=> $request->input('title'),
            'sub_title'=> $request->input('sub_title'),
            'url'=> $request->input('url'),
            'tags'=> $request->input('tags'),
            'short_description'=> $request->input('short_description'),
            'header_image_url'=> $request->input('header_image_url'),
            'cover_image_url'=> $request->input('cover_image_url'),
            'hidden'=> $request->input('hidden'),
        ];

        $page = new Page;
        $page->fill($data);
        $page->parent_id = $request->input('parent_id');
        $page->save();

        return response()->json(['message'=>'page create sucessfully'], 201);
    }

    public function createCssClass(Request $request): JsonResponse
    {
        $data = [
            'placeholder'=> $request->input('placeholder'),
            'reference_name'=> $request->input('reference_name'),
            'json'=> $request->input('json'),
            'css'=> $request->input('css'),
            'custom_css'=> $request->input('custom_css')
        ];

        $class = new CssClass;
        $class->fill($data);
        $class->tags = $request->input('tags');
        $class->save();

        return response()->json(['message'=>'class created sucessfully']);
    }

    public function createModule(Request $request): JsonResponse
    {
        $data = [
            'placeholder'=> $request->input('placeholder'),
            'animation_style'=> $request->input('animation_style'),
            'title'=> $request->input('title'),
            'subtitle'=> $request->input('subtitle'),
            'width'=> $request->input('width'),
            'content'=> $request->input('content')
        ];

        $class = new Module;
        $class->fill($data);
        $class->class_id = $request->input('class_id');
        $class->save();

        return response()->json(['message'=>'Module created sucessfully']);
    }

    public function addModuleToPage(Request $request): JsonResponse
    {
        $data = [
            'page_id'=> $request->input('page_id'),
            'module_id'=> $request->input('module_id')
            ];

        $page = Page::find($data['page_id']);

        $module = Module::find($data['module_id']);

        $page->modules()->attach($module);
        return response()->json(['message' => 'Module added to page successfully']);
    }
    public function addDisplayToModule(Request $request): JsonResponse
    {
        $data = [
            'display_id'=> $request->input('display_id'),
            'module_id'=> $request->input('module_id')
        ];

        $display = Display::find($data['display_id']);

        $module = Module::find($data['module_id']);

        $module->displays()->attach($display);
        return response()->json(['message' => 'Display added to module successfully']);

    }

    public function createGridSetting(Request $request): JsonResponse
    {
        $data = [
            'blocks_count'=> $request->input('blocks_count'),
            'blocks_per_row'=> $request->input('blocks_per_row'),
            'blocks_spacing'=> $request->input('blocks_spacing'),
            'blocks_animation'=> $request->input('blocks_animation'),
            'horizontal_alignment'=> $request->input('horizontal_alignment'),
            'vertical_alignment'=> $request->input('vertical_alignment')
        ];

        $gridSettings = new GridSetting;
        $gridSettings->fill($data);
        $gridSettings->class_id = $request->input('class_id');
        $gridSettings->save();

        return response()->json(['message'=>'grid settings created sucessfully']);
    }

    public function createSliderSetting(Request $request): JsonResponse
    {
        $data = [
            'slides_per_row'=> $request->input('slides_per_row'),
            'slides_per_column'=> $request->input('slides_per_column'),
            'total_slides'=> $request->input('total_slides'),
            'slides_spacing'=> $request->input('slides_spacing'),
            'center_slides'=> $request->input('center_slides'),
            'loop_slides'=> $request->input('loop_slides'),
            'auto_height'=> $request->input('auto_height'),
            'stretch_height'=> $request->input('stretch_height'),
            'auto_play'=> $request->input('auto_play'),
            'arrows'=> $request->input('arrows'),
            'bullets'=> $request->input('bullets'),
            'animation'=> $request->input('animation'),
            'effect_speed_ms'=> $request->input('effect_speed_ms')

        ];

        $silderSettings = new SliderSetting;
        $silderSettings->fill($data);
        $silderSettings->class_id = $request->input('class_id');
        $silderSettings->save();

        return response()->json(['message'=>'slider settings created sucessfully']);
    }

    public function createDisplay(Request $request): JsonResponse
    {
        $data = [
            'placeholder'=> $request->input('placeholder'),
            'type'=> $request->input('type'),
            'display_template'=> $request->input('display_template'),
            'source_page_id'=> $request->input('source_page_id')
        ];

        $display = new Display;
        $display->fill($data);
        if($data['type'] == "slider"){
            $display->slider_settings_id = $request->input('slider_settings_id');
        }
        else if ($data['type'] == "grid"){
            $display->grid_settings_id = $request->input('grid_settings_id');
        }

        $display->save();

        return response()->json(['message'=>'Display is create sucessfully']);
    }

}
