<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{

    /**
     * @param mixed $trustedData
     * @return void
     */
    public function createUser(mixed $trustedData): void
    {
        User::create([
            'name' => $trustedData['name'],
            'email' => $trustedData['email'],
            'password' => Hash::make($trustedData['password'])
        ]);
    }
}
