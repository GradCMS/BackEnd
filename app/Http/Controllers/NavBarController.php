<?php

namespace App\Http\Controllers;

use App\Http\Services\NavBarService;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NavBarController extends Controller
{
     private $navBarService;

     public function __construct(NavBarService $navBarService)
     {
         $this->navBarService = $navBarService;
     }
     public function addElement(Request $request):JsonResponse
     {
         $validator = Validator::make($request->all(),[
             'parent_id'=>'exists:navbars,id',
             'referenced_page'=>'exists:pages,id'
         ]);

         if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()], 422);
         }
         $navBar = $this->navBarService->addElement($request->all());

         return response()->json([
             'message'=>'NavBar Element has been created successfully',
             'navbar'=>$navBar
         ], 201);

     }

     public function getNavBar():JsonResponse
     {
         $elements = $this->navBarService->getNavBar();

         return response()->json([
             'navBar'=>$elements
         ]);
     }

    public function deleteElement($id):JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|exists:navbars'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $this->navBarService->deleteElement($id);

        return response()->json([
            'message'=>'Element with ID '.$id.' has been deleted successfully'
        ]);
    }

    public function updateElement(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all() + ['id' => $id], [
            'id' => 'required|integer|exists:navbars',
            'parent_id'=>'exists:navbars,id',
            'referenced_page'=>'exists:pages,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $updatedElement = $this->navBarService->updateElement($id, $request->all());

        return response()->json([
            'message'=>'Element with ID '.$id.' has been updated successfully',
            'updated_element'=>$updatedElement
        ]);
    }
}
