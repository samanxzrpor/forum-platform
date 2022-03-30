<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\API\V1\Channel\ChannelsController;



Route::prefix('channel')->group(function () {

    Route::get('list' , [ChannelsController::class , 'index'])
        ->name('channels.list');

    Route::get('show' , [ChannelsController::class , 'show'])
        ->name('channels.one');

    Route::middleware(['can:channel management','auth:sanctum'])->group(function () {

        Route::post('store' , [ChannelsController::class , 'store'])
            ->name('channels.create');

        Route::put('update' , [ChannelsController::class , 'update'])
            ->name('channels.update');

        Route::delete('delete' , [ChannelsController::class , 'delete'])
            ->name('channels.delete');
    });

});
