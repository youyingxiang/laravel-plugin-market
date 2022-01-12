<?php

use Illuminate\Support\Facades\Route;
use Yxx\LaravelPluginMarket\Http\Controllers\PluginsController;
use Yxx\LaravelPluginMarket\Http\Controllers\RegisterController;
use Yxx\LaravelPluginMarket\Http\Controllers\LoginController;
use Yxx\LaravelPluginMarket\Http\Controllers\UserController;
use Yxx\LaravelPluginMarket\Http\Controllers\UploadController;
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

Route::prefix("pluginmarket")->group(function (){
    Route::middleware("auth:sanctum")->group(function (){
        Route::resource('pluginversions',  'PluginsVersionsController');
        Route::post("plugins", [PluginsController::class,"store"]);
        Route::get("user-info", [UserController::class, "getUserInfo"]);
        Route::get("user/plugins/{status}", [UserController::class,"getPlugins"]);
        Route::post("plugins/install/{versionId}", [PluginsController::class,"install"]);
        Route::post('upload/image',  [UploadController::class, 'image']);
        Route::resource('download-histories', 'PluginDownloadsController')->only('index');
        Route::resource('users', 'UserController');
    });
    Route::get("plugins/count", [PluginsController::class,"count"]);
    Route::get("plugins", [PluginsController::class,"index"]);
    Route::post("register",[RegisterController::class, 'register']);
    Route::post("login",[LoginController::class, 'login']);
});