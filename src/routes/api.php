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

    # Channels Process Route
    include __DIR__ .'/v1/channels_routes.php';

    # Threads Process Route
    include __DIR__ .'/v1/threads_routes.php';

    # Users Routes
    include __DIR__ .'/v1/users_routes.php';

});

