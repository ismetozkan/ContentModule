<?php

use App\Http\Controllers\ContentController;
use App\Http\Controllers\ContentsToTypeController;
use App\Http\Controllers\ContentTypesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('user')->group(function () {
    Route::any('/', [UserController::class, 'read'])->name('user.read');
    Route::any('create', [UserController::class, 'create'])->name('user.create');
    Route::any('update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::any('delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    Route::any('view/{id}', [UserController::class, 'view'])->name('user.view');
});

Route::prefix('contents')->group(function () {

    Route::prefix('types')->group(function () {
        Route::any('/', [ContentTypesController::class, 'read'])->name('types.read');
        Route::any('create', [ContentTypesController::class, 'create'])->name('types.create');
        Route::any('update/{id}', [ContentTypesController::class, 'update'])->name('types.update');
        Route::any('delete/{id}', [ContentTypesController::class, 'delete'])->name('types.delete');
        Route::any('view/{id}', [ContentTypesController::class, 'view'])->name('types.view');
    });

        Route::any('/', [ContentController::class, 'read'])->name('contents.read');
        Route::any('create', [ContentController::class, 'create'])->name('contents.create');
        Route::any('update/{id}', [ContentController::class, 'update'])->name('contents.update');
        Route::any('delete/{id}', [ContentController::class, 'delete'])->name('contents.delete');
        Route::any('view/{id}', [ContentController::class, 'view'])->name('contents.view');
});

Route::prefix('contentstotype')->group(function () {
    Route::any('/', [ContentsToTypeController::class, 'read'])->name('contentstotype.read');
    Route::any('update/{id}', [ContentsToTypeController::class, 'update'])->name('contentstotype.update');
});

