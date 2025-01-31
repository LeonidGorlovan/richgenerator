<?php

use App\Modules\RichGenerator\Backend\Controllers\RichDocumentBrandsController;
use App\Modules\RichGenerator\Backend\Controllers\RichDocumentLangsController;
use App\Modules\RichGenerator\Backend\Controllers\RichDocumentsController;
use App\Modules\RichGenerator\Backend\Controllers\TemplateStyleController;
use App\Modules\RichGenerator\Enums\TemplateEnum;
use App\Modules\RichGenerator\Models\RichDocumentBrand;
use App\Modules\RichGenerator\Services\ParseHtmlService;
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

//Route::get('test', function (Request $request) {
//    return (new ParseHtmlService())->downloadArchive(6);
//});

Route::prefix(config('delta.backend_prefix'))
    ->middleware(['web', 'api', 'localize'])
    ->group(function () {
        Route::get('options/layout', App\Http\Controllers\Backend\LayoutController::class);

        Route::get('generator/export/{id}', [RichDocumentsController::class, 'export'])->name('generator.export')->middleware('resource_can:rich_generator');
        Route::resource('generator', RichDocumentsController::class)->middleware('resource_can:rich_generator');
        Route::resource('langs', RichDocumentLangsController::class)->middleware('resource_can:rich_generator');
        Route::resource('brands', RichDocumentBrandsController::class)->middleware('resource_can:rich_generator');
        Route::resource('templatestyle', TemplateStyleController::class)->middleware('resource_can:template_styles');
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
