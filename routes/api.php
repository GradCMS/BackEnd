<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\test;
use App\Http\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('page/{id?}', [PageController::class, 'getPage']);
Route::get('permission/{id}', [PermissionController::class,'getPermission']);




// test routes
Route::post('createPage', [test::class, 'createPage']);
Route::post('createClass', [test::class, 'createCssClass']);
Route::post('createModule', [test::class, 'createModule']);
Route::post('addModule', [test::class, 'addModuleToPage']);
Route::post('createGrid', [test::class, 'createGridSetting']);
Route::post('createSlider', [test::class, 'createSliderSetting']);
Route::post('createDisplay', [test::class, 'createDisplay']);
Route::post('addDisplayToModule', [test::class, 'addDisplayToModule']);
Route::post('createUser', [test::class, 'createUser']);



//  Auth routes
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('refresh', [AuthController::class, 'refresh']);
Route::post('me', [AuthController::class, 'me']);

