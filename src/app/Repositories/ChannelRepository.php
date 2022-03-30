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

    /**
     * @param mixed $trustedData
     * @return void
     */
    public function updateChannel(mixed $trustedData): void
    {
        Channel::find($trustedData['id'])->update([
            'name' => $trustedData['name'],
            'slug' => Str::slug($trustedData['name'])
        ]);
    }

    public function getOneChannel(mixed $request)
    {
        $field = array_key_first($request);
        return Channel::where($field,$request[$field])->first();
    }
}
