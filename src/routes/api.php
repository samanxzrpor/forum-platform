<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('v1')->group(function (){

    # Authentication Route
    include __DIR__ .'/v1/auth_routes.php';

    # Channels Route
    include __DIR__ .'/v1/channels_routes.php';

});

