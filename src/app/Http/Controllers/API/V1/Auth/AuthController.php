<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\Register;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{

    /**
     * Register Action
     * @method POST
     * @param Register $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Register $request)
    {
        # Validation Request
        $trustedData = $request->validated();

        # insert User In Database
        resolve(UserRepository::class)->createUser($trustedData);

        return response()->json([
            'message'=>'user created successfully'
        ],201);
    }


    /**
     * Login Action
     * @method POST
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function login(LoginRequest $request)
    {
        $trustedData = $request->validated();

        if (Auth::attempt(['email' => $trustedData['email'], 'password' => $trustedData['password']]))
            return response()->json(Auth::user() , 200);

        throw ValidationException::withMessages([
            'email' => 'incorrect credentials'
        ]);
    }

    public function getUser()
    {
        return response()->json(Auth::user() , 200);
    }


    public function logout()
    {
        Auth::logout();
    }

}
