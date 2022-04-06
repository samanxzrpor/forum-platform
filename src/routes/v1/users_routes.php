<?php

use App\Http\Controllers\API\V1\User\UserController;
use Illuminate\Support\Facades\Route;



Route::prefix('/users')->group(function (){

    Route::get('/leaderboard' , [UserController::class , 'leaderboard'])->name('users.leaderboard');

});
