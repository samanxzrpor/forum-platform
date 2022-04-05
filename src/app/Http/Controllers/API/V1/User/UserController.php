<?php

namespace App\Http\Controllers\API\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    public function userNotifications()
    {
        return response()->json([
            'notifications' => Auth::user()->unreadNotifications()
        ] , Response::HTTP_OK);
    }
}