<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\API\V1\Channel\ChannelsController;



Route::prefix('channel')->group(function () {

    Route::get('all' , [ChannelsController::class , 'getAllChannels'])
        ->name('channels.list');

    Route::get('get' , [ChannelsController::class , 'getOneChannel'])
        ->name('channels.one');

    Route::middleware('can:channel management')->group(function () {

        Route::post('store' , [ChannelsController::class , 'createNewChannel'])
            ->name('channels.create');

        Route::put('update' , [ChannelsController::class , 'updateChannel'])
            ->name('channels.update');

        Route::delete('delete' , [ChannelsController::class , 'deleteChannel'])
            ->name('channels.delete');
    });

});
