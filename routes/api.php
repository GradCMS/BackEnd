<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PermissionController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\CssClassController;
use App\Http\Controllers\NavBarController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\SiteIdentityController;
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

    Route::post('upload', [test::class,'dummyUploadImage']);
});



// Auth routes
Route::prefix('auth')->group(function (){

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);

});

// Role routes
Route::prefix('roles')->group(function (){

    Route::post('/', [RoleController::class, 'createRole']);
        // ->middleware('permission:role management');

    Route::get('/', [RoleController::class, 'getAllRoles']);

    Route::patch('/{id}',[RoleController::class, 'updateRole']);
        // ->middleware('permission:role management');

    Route::delete('/{id}', [RoleController::class, 'deleteRole']);
        // ->middleware('permission:role management');

});

Route::prefix('permissions')->group(function(){

    Route::get('/',[PermissionController::class, 'getPermissions']);
});

Route::prefix('users')->group(function(){

    Route::post('/',[UserController::class, 'createUser']);
        // ->middleware('permission:user management');

    Route::get('/',[UserController::class, 'getUsers']);

    Route::get('/count',[UserController::class, 'getUsersCount']);

    Route::get('/suspended',[UserController::class, 'getSuspendedUsers']);
        // ->middleware('permission:user management');

    Route::get('/unsuspended',[UserController::class, 'getUnsuspendedUsers']);
    

    Route::get('/{id}',[UserController::class, 'getUserById']);

    Route::patch('/{id}',[UserController::class, 'updateUser']);
        // ->middleware('permission:user management');

    Route::delete('/{id}',[UserController::class, 'deleteUser']);
        // ->middleware('permission:user management');

    Route::patch('/{id}/suspend',[UserController::class, 'suspendUser']);
        // ->middleware('permission:user management');

    Route::patch('/{id}/unsuspend',[UserController::class, 'unsuspendUser']);
        // ->middleware('permission:user management');

});

Route::prefix('pages')->group(function(){

    Route::post('/',[PageController::class, 'createPage']);
        // ->middleware('permission:page management');

    Route::get('/parents', [PageController::class, 'getParentPages']);

    Route::get('/standard', [PageController::class, 'getStandardPages']);

    Route::post('/modules', [PageController::class, 'syncModules']);
        // ->middleware('permission:page management');

    Route::post('/displays', [PageController::class, 'syncDisplays']);
        // ->middleware('permission:page management');

    Route::get('/tree', [PageController::class, 'getPagesTree']);

    Route::get('/tree/{id}',[PageController::class, 'getPagechildren']);

    Route::get('/', [PageController::class, 'getAllPages']);

    Route::get('/{id}', [PageController::class, 'getPageById']);

    Route::delete('/{id}', [PageController::class, 'deletePage']);
        // ->middleware('permission:page management');

    Route::patch('/{id}',[PageController::class, 'updatePage']);
        // ->middleware('permission:page management');

});


// Css Class

Route::prefix('cssClass')->group(function (){

    Route::get('/{id}', [CssClassController::class,'getCssClass']);

    Route::get('/',[CssClassController::class,'getCssClasses']);

    Route::post('/',[CssClassController::class,'createCssClass']);
        // ->middleware('permission:class management');

    Route::delete('/{id}',[CssClassController::class,'deleteCssClass']);
        // ->middleware('permission:class management');

    Route::patch('/{id}',[CssClassController::class,'updateCssClass']);
        // ->middleware('permission:class management');

});

// Module

Route::prefix('module')->group(function (){

    Route::get('/{id}', [ModuleController::class,'getModule']);

    Route::get('/',[ModuleController::class,'getModules']);

    Route::post('/',[ModuleController::class,'createModule']);
        // ->middleware('permission:module management');

    Route::delete('/{id}',[ModuleController::class,'deleteModule']);
        // ->middleware('permission:module management');

    Route::patch('/{id}',[ModuleController::class,'updateModule']);
        // ->middleware('permission:module management');

});

//Display

Route::prefix('display')->group(function (){

    Route::get('/{id}', [DisplayController::class,'getDisplay']);

    Route::get('/',[DisplayController::class,'getAllDisplays']);

    Route::post('/',[DisplayController::class,'createDisplay']);
        // ->middleware('permission:display management');

    Route::delete('/{id}',[DisplayController::class,'deleteDisplay']);
        // ->middleware('permission:display management');

    Route::patch('/{id}',[DisplayController::class,'updateDisplay']);
        // ->middleware('permission:display management');

});

Route::prefix('siteIdentity')->group(function (){

    Route::get('/latest', [SiteIdentityController::class,'getLatestRecord']);

    Route::get('/{id}', [SiteIdentityController::class,'getSiteIdentity']);

    Route::post('/',[SiteIdentityController::class,'createSiteIdentity']);
        // ->middleware('permission:siteIdentity management');

    Route::patch('/{id}',[SiteIdentityController::class,'updateSiteIdentity']);
        // ->middleware('permission:siteIdentity management');

    Route::delete('/{id}',[SiteIdentityController::class,'deleteSiteIdentity']);
        // ->middleware('permission:siteIdentity management');

});

Route::prefix('navBar')->group(function (){

    Route::get('/{id}', [NavBarController::class,'getNavBarElem']);

    Route::get('/', [NavBarController::class,'getNavBar']);

    Route::post('/',[NavBarController::class, 'addElement']);
        // ->middleware('permission:navBar management');

    Route::patch('/{id}',[NavBarController::class,'updateElement']);
        // ->middleware('permission:navBar management');

    Route::delete('/{id}',[NavBarController::class,'deleteElement']);
        // ->middleware('permission:navBar management');

});

