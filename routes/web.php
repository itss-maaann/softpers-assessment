<?php

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
    return redirect('file');
});

Route::prefix('file')->group(function () {
    Route::name('file.')->group(function () {
        Route::controller(ExcelController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/import-files', 'importView')->name('importView');
            Route::post('/import', 'import')->name('import');
            Route::get('/export-file/{file}', 'exportFile')->name('export-file');
            Route::get('/view-file/{file}', 'viewFile')->name('viewFile');
        });
    });
});
