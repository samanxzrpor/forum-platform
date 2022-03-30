<?php

use App\Http\Controllers\API\V1\Thraed\ThreadsController;
use Illuminate\Support\Facades\Route;


Route::prefix('thread')->group(function (){

    Route::get('list' , [ThreadsController::class , 'index'])->name('thread.list');
    Route::get('show' , [ThreadsController::class , 'show'])->name('thread.show');
});
