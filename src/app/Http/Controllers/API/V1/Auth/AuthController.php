<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Register;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * @methods Post
     * @param Register $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Register $request)
    {
        # Validation Request
        $request->validated();

        # insert User In Database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message'=>'user created successfully'
        ],201);
    }

    public function login()
    {
    }

    public function logout()
    {

    }
}
