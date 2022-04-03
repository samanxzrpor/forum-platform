<?php

use App\Http\Controllers\API\V1\Thraed\ThreadsController;
use Illuminate\Support\Facades\Route;


Route::prefix('/thread')->group(function (){

    Route::get('/list' , [ThreadsController::class , 'index'])->name('thread.list');
    Route::get('/show' , [ThreadsController::class , 'show'])->name('thread.show');

    Route::middleware('auth:sanctum')->group(function () {

        Route::put('{thread}/update' , [ThreadsController::class , 'update'])->name('thread.update');
        Route::post('/store' , [ThreadsController::class , 'store'])->name('thread.store');
        Route::delete('{id}/delete' , [ThreadsController::class , 'delete'])->name('thread.delete');
    });
});
