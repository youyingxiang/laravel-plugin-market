<?php

use Illuminate\Support\Facades\Route;
use Plugins\PluginMarket\Http\Controllers\PluginsController;
use Plugins\PluginMarket\Http\Controllers\RegisterController;
use Plugins\PluginMarket\Http\Controllers\LoginController;
use Plugins\PluginMarket\Http\Controllers\UserController;
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
        Route::post("plugins", [PluginsController::class,"store"]);
        Route::get("user-info", [UserController::class, "getUserInfo"]);
        Route::get("user/plugins", [UserController::class,"getPlugins"]);
        Route::post("plugins/install/{versionId}", [PluginsController::class,"install"]);
    });
    Route::get("plugins/count", [PluginsController::class,"count"]);
    Route::get("plugins", [PluginsController::class,"index"]);
    Route::post("register",[RegisterController::class, 'register']);
    Route::post("login",[LoginController::class, 'login']);
});