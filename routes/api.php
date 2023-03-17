<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
//
//Route::get('page/{id?}', [PageController::class, 'getPage']);
//Route::get('permission/{id}', [PermissionController::class,'getPermission']);




// test routes
Route::prefix('test')->group(function(){
    Route::post('createPage', [test::class, 'createPage']);
    Route::post('createClass', [test::class, 'createCssClass']);
    Route::post('createModule', [test::class, 'createModule']);
    Route::post('addModule', [test::class, 'addModuleToPage']);
    Route::post('createGrid', [test::class, 'createGridSetting']);
    Route::post('createSlider', [test::class, 'createSliderSetting']);
    Route::post('createDisplay', [test::class, 'createDisplay']);
    Route::post('addDisplayToModule', [test::class, 'addDisplayToModule']);
    Route::post('createUser', [test::class, 'createUser']);
    Route::post('createRole', [test::class, 'createRole']);
    Route::get('getRoles', [test::class, 'getRoles']);
    Route::post('addPermissions', [test::class, 'addPermissionsToRole']);
    Route::get('getPage/{id}',[test::class,'getPage']);
    Route::get('getPageModules/{id}',[test::class, 'getPageModules']);
});


// Auth routes
Route::prefix('auth')->group(function (){
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

// Role routes
Route::prefix('roles')->group(function (){
    Route::post('create', [RoleController::class, 'createRole']);
    Route::get('/', [RoleController::class, 'getAllRoles']);
    Route::patch('/{id}/update',[RoleController::class, 'updatePermissions']);
    Route::delete('delete/{id}', [RoleController::class, 'deleteRole']);
});

Route::prefix('permissions')->group(function(){
    Route::get('/',[PermissionController::class, 'getPermissions']);
});



