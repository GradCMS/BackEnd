<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Services\Auth\AuthService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
//    dd(app());
    return view('welcome');
});



Route::get('unathorized', [AuthService::class, 'unauthorized']);
