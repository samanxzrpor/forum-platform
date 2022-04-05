<?php

namespace App\Repositories;

use App\Models\Subscribe;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\NewReplayThread;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class UserRepository
{

    /**
     * @param mixed $trustedData
     * @return void
     */
    public function createUser(mixed $trustedData) : User
    {
        return User::create([
            'name' => $trustedData['name'],
            'email' => $trustedData['email'],
            'password' => Hash::make($trustedData['password'])
        ]);
    }

    /**
     * @param $thread_id
     * @return void
     */
    public function sendNotification($thread_id): void
    {
        $users = Subscribe::query()->where('thread_id', $thread_id)->pluck('user_id')->all();

        Notification::send(User::find($users), new NewReplayThread(Thread::find($thread_id)));

    }
}
