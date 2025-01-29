<?php

use CfDigital\Delta\Core\Http\Controllers\HomePageController;
use CfDigital\Delta\Core\Http\Controllers\PageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
 *
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix(config('delta.backend_prefix'))
    ->middleware(['web', 'api', 'localize'])
    ->group(function () {

        Route::get('options/layout', App\Http\Controllers\Backend\LayoutController::class);
    });

Route::middleware(['api', 'localize'])
    ->group(function () {
        Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
            return $request->user();
        });

        Route::get('/', HomePageController::class);
        Route::get('options/layout', \App\Http\Controllers\Api\LayoutController::class);
        Route::get('{slug}', PageController::class)->where(['slug' => '.*']);
    });
