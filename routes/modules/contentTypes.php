<?php

use App\Http\Controllers\ContentTypesController;

Route::prefix('contents')->group(function () {

    Route::prefix('types')->group(function () {
        Route::any('/', [ContentTypesController::class, 'read'])->name('types.read');
        Route::any('create', [ContentTypesController::class, 'create'])->name('types.create');
        Route::any('update/{id}', [ContentTypesController::class, 'update'])->name('types.update');
        Route::any('delete/{id}', [ContentTypesController::class, 'delete'])->name('types.delete');
        Route::any('view/{id}', [ContentTypesController::class, 'view'])->name('types.view');
    });
});
