<?php

use App\Http\Controllers\ContentController;
use App\Http\Controllers\ContentsTypeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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
    Route::any('update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::any('create/{id}', [UserController::class, 'create'])->name('user.create');
    Route::any('delete/{id}', [UserController::class, 'delete'])->name('user.delete');
});

Route::prefix('contents')->group(function () {

    Route::prefix('type')->group(function () {
        Route::any('/', [ContentsTypeController::class, 'read'])->name('type.read');
        Route::any('create/{id}', [ContentsTypeController::class, 'create'])->name('type.create');
        Route::any('update/{id}', [ContentsTypeController::class, 'update'])->name('type.update');
        Route::any('delete/{id}', [ContentsTypeController::class, 'delete'])->name('type.delete');
    });

        Route::any('/', [ContentController::class, 'read'])->name('contents.read');
        Route::any('create/{id}', [ContentController::class, 'create'])->name('contents.create');
        Route::any('update/{id}', [ContentController::class, 'update'])->name('contents.update');
        Route::any('delete/{id}', [ContentController::class, 'delete'])->name('contents.delete');
});

Route::prefix('contentstotype')->group(function () {
    Route::any('/', [UserController::class, 'read'])->name('contentstotype.read');
    Route::any('create/{id}', [UserController::class, 'create'])->name('contentstotype.create');
    Route::any('update/{id}', [UserController::class, 'update'])->name('contentstotype.update');
    Route::any('delete/{id}', [UserController::class, 'delete'])->name('contentstotype.delete');
});
