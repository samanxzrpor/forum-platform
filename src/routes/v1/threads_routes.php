<?php

use App\Http\Controllers\API\V1\Subscribe\SubscribesController;
use App\Http\Controllers\API\V1\Thread\AnswersContrller;
use App\Http\Controllers\API\V1\Thread\ThreadsController;
use Illuminate\Support\Facades\Route;


Route::prefix('/thread')->group(function (){

    Route::get('/list' , [ThreadsController::class , 'index'])->name('thread.list');
    Route::get('{slug}/show' , [ThreadsController::class , 'show'])->name('thread.show');
    Route::middleware('auth:sanctum')->group(function () {
        Route::put('{thread}/update' , [ThreadsController::class , 'update'])->name('thread.update');
        Route::post('/store' , [ThreadsController::class , 'store'])->name('thread.store');
        Route::delete('{id}/delete' , [ThreadsController::class , 'delete'])->name('thread.delete');
    });


    Route::prefix('/answers')->group(function (){
        Route::get('/list' , [AnswersContrller::class , 'index'])->name('answers.list');
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/store' , [AnswersContrller::class , 'store'])->name('answers.store');
            Route::put('{answer}/update' , [AnswersContrller::class , 'update'])->name('answers.update');
            Route::delete('{answer}/delete' , [AnswersContrller::class , 'destroy'])->name('answers.delete');
        });
    });


    Route::middleware('auth:sanctum')->group(function () {
        Route::post('{thread}/sub' , [SubscribesController::class , 'subscribe'])->name('subscribe');
        Route::post('{thread}/unsub' , [SubscribesController::class , 'unsubscribe'])->name('unsubscribe');
    });
});
