<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\API\V1\Auth\AuthController;



Route::prefix('/auth')->group(function (){

    Route::post('/register' , [AuthController::class , 'register'])->name('auth.register');
    Route::post('/login' , [AuthController::class , 'login'])->name('auth.login');
    Route::post('/user' , [AuthController::class , 'getUser'])->name('auth.user');
    Route::post('/logout' , [AuthController::class , 'logout'])->name('auth.logout');

});
