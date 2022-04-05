<?php

use \Illuminate\Support\Facades\Route;
use \App\Http\Controllers\API\V1\Thread\AnswersContrller;


Route::prefix('/answer')->group(function (){

    Route::get('/list' , [AnswersContrller::class , 'index'])->name('answers.list');
    Route::get('{answer}/show' , [AnswersContrller::class , 'show'])->name('answers.show');

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/store' , [AnswersContrller::class , 'store'])->name('answers.store');
        Route::put('{answer}/update' , [AnswersContrller::class , 'update'])->name('answers.update');
        Route::delete('{answer}/delete' , [AnswersContrller::class , 'destroy'])->name('answers.delete');
    });
});
