<?php

namespace App\Http\Controllers;

use App\Http\Services\PageService;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{

    private $pageService;
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    public function createPage(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'hidden'=> 'boolean',
            'parent_id'=>'exists:pages,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $page = $this->pageService->createPage($request->all());

        return response()->json([
            'message'=>'Page has been created successfully',
            'page'=>$page
        ], 201);
    }

    public function getPagesTree():JsonResponse
    {
        $tree = $this->pageService->getPagesTree();

        return response()->json([
           'tree'=>$tree
        ]);
    }
    public function getPagechildren($id):JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'integer|exists:pages',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $children = $this->pageService->getPageChildren($id);

        return response()->json([
            'children'=>$children
        ]);
    }

    public function getAllPages():JsonResponse
    {
        $pages = $this->pageService->getAllPages();

        return response()->json([
            'pages'=>$pages
        ]);
    }
    public function getPageById($id):JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'integer|exists:pages',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $page = $this->pageService->getPageById($id);

        return response()->json([
           'page'=>$page
        ]);
    }

    public function deletePage($id):JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:pages'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $this->pageService->deletePage($id);

        return response()->json([
            'message'=>'Page with ID '.$id.' has been deleted successfully'
        ]);
    }

    public function updatePage(Request $request, $pageID):JsonResponse
    {

        $validator = Validator::make(['id' => $pageID], [
            'id' => 'required|integer|exists:pages'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pageData = $request->all();

        $this->pageService->updatePage($pageID, $pageData);


        return response()->json([
            'message'=>'Page with ID '.$pageID.' has been updated successfully',
            'updated_Page'=>Page::find($pageID)
        ]);
    }

    public function syncModules(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'page_id'=> 'integer|exists:pages,id',
            'modules'=>'array',
            'modules.*.id'=>'exists:modules,id',
            'modules.*.priority'=>'integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pageID = $request->input('page_id');
        $modules = $request->input('modules');


        $this->pageService->syncModules($pageID, $modules);

        return response()->json(['message' => 'Modules synced successfully.']);


    }

    public function syncDisplays(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'page_id'=> 'integer|exists:pages,id',
            'displays'=>'array',
            'displays.*.id'=>'exists:displays,id',
            'displays.*.priority'=>'integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pageID = $request->input('page_id');
        $displays = $request->input('displays');


        $this->pageService->syncDisplays($pageID, $displays);

        return response()->json(['message' => 'Displays synced successfully.']);


    }
    public function getParentPages()
    {
        $parentPages = $this->pageService->getParentPages();

        return response()->json([
           'parentPages'=>$parentPages
        ]);
    }

    public function getStandardPages()
    {
        $standardPages = $this->pageService->getStandardPages();

        return response()->json([
            'standardPages'=>$standardPages
        ]);
    }

}
