<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PermissionController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\CssClassController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\test;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModuleController;

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

/**
 * ALL ROUTES MUST BE MIDDLEWARED WITH 'AUTH'
*/


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

    Route::get('modules', [test::class, 'getModules']);

    Route::get('test123', [test::class, 'test123']);

    Route::get('getCssClass/{id}', [test::class,'getCssClass']);

    Route::get('getCssClasses',[test::class,'getCssClasses']);
});

// Css Class

Route::prefix('cssClass')->group(function (){

    Route::get('/{id}', [CssClassController::class,'getCssClass']);

    Route::get('/',[CssClassController::class,'getCssClasses']);

    Route::post('/',[CssClassController::class,'createCssClass']);

    Route::delete('/{id}',[CssClassController::class,'deleteCssClass']);

    Route::patch('/{id}',[CssClassController::class,'updateCssClass']);

});

// Module

Route::prefix('module')->group(function (){

    Route::get('/{id}', [ModuleController::class,'getModule']);

    Route::get('/',[ModuleController::class,'getModules']);

    Route::post('/',[ModuleController::class,'createModule']);

    Route::delete('/{id}',[ModuleController::class,'deleteModule']);

    Route::patch('/{id}',[ModuleController::class,'updateModule']);

});

//Display

Route::prefix('display')->group(function (){

    Route::get('/{id}', [DisplayController::class,'getDisplay']);

    Route::get('/',[DisplayController::class,'getAllDisplays']);

    Route::post('/',[DisplayController::class,'createDisplay']);

    Route::delete('/{id}',[DisplayController::class,'deleteDisplay']);

    Route::patch('/{id}',[DisplayController::class,'updateDisplay']);

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

    Route::post('/', [RoleController::class, 'createRole']);
//        ->middleware('permission:create role');

    Route::get('/', [RoleController::class, 'getAllRoles']);

    Route::patch('/{id}',[RoleController::class, 'updateRole']);
//        ->middleware('permission:update role');

    Route::delete('/{id}', [RoleController::class, 'deleteRole']);
//        ->middleware('permission:delete role');

});

Route::prefix('permissions')->group(function(){

    Route::get('/',[PermissionController::class, 'getPermissions']);
});

Route::prefix('users')->group(function(){

    Route::post('/',[UserController::class, 'createUser']);
//        ->middleware('permission:create user');

    Route::get('/',[UserController::class, 'getUsers']);

    Route::get('/count',[UserController::class, 'getUsersCount']);

    Route::get('/suspended',[UserController::class, 'getSuspendedUsers']);

    Route::patch('/{id}',[UserController::class, 'updateUser']);
//        ->middleware('permission:update user');

    Route::delete('/{id}',[UserController::class, 'deleteUser']);
//        ->middleware('permission:delete user');

    Route::patch('/{id}/suspend',[UserController::class, 'suspendUser']);
//        ->middleware('permission:suspend user');

    Route::patch('/{id}/unsuspend',[UserController::class, 'unsuspendUser']);
//        ->middleware('permission:unsuspend user');

});

Route::prefix('pages')->group(function(){

    Route::post('/',[PageController::class, 'createPage']);

    Route::post('/modules', [PageController::class, 'syncModules']);

    Route::get('/', [PageController::class, 'getAllPages']);

    Route::get('/tree', [PageController::class, 'getPagesTree']);

    Route::get('/{id}', [PageController::class, 'getPageById']);

    Route::delete('/{id}', [PageController::class, 'deletePage']);

    Route::patch('/{id}',[PageController::class, 'updatePage']);

});


