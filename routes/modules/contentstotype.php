<?php

use App\Http\Controllers\ContentsToTypeController;

Route::prefix('contentstotype')->group(function () {
    Route::any('/', [ContentsToTypeController::class, 'read'])->name('contentstotype.read');
    Route::any('create', [ContentsToTypeController::class, 'create'])->name('contentstotype.create');
    Route::any('update/{id}', [ContentsToTypeController::class, 'update'])->name('contentstotype.update');
    Route::any('delete/{id}', [ContentsToTypeController::class, 'delete'])->name('contentstotype.delete');
});
