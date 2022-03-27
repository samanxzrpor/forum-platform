<?php

namespace App\Repositories;

use App\Models\Channel;
use Illuminate\Support\Str;

class ChannelRepository
{

    /**
     * @param $trustedData
     * @return void
     */
    public function createChannel($trustedData): void
    {
        Channel::create([
            'name' => $trustedData['name'],
            'slug' => Str::slug($trustedData['name']),
            'user_id' => $trustedData['user_id'],
        ]);
    }
}
