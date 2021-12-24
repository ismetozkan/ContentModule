<?php


use App\Http\Controllers\ContentController;

Route::prefix('contents')->group(function (){
    Route::any('/', [ContentController::class, 'read'])->name('contents.read');
    Route::any('create', [ContentController::class, 'create'])->name('contents.create');
    Route::any('update/{id}', [ContentController::class, 'update'])->name('contents.update');
    Route::any('delete/{id}', [ContentController::class, 'delete'])->name('contents.delete');
    Route::any('view/{id}', [ContentController::class, 'view'])->name('contents.view');
});
