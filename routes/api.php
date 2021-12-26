<?php

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

Route::prefix('/v1')->group(function (){
    include "modules.php";
    foreach ($modules as $module) {
        include sprintf("modules/%s.php",$module);
    }
});

Route::prefix('user')->group(function () {
    Route::any('/', [UserController::class, 'read'])->name('user.read');
    Route::any('create', [UserController::class, 'create'])->name('user.create');
    Route::any('update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::any('delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    Route::any('view/{id}', [UserController::class, 'view'])->name('user.view');
});





