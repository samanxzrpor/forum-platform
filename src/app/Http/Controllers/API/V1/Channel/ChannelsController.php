<?php

namespace App\Http\Controllers\API\V1\Channel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Channels\StoreChannelRequest;
use App\Models\Channel;
use App\Repositories\ChannelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChannelsController extends Controller
{

    /**
     * @param StoreChannelRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createNewChannel(StoreChannelRequest $request)
    {
        $trustedData = $request->validated();

        # Create New Channel in Database
        resolve(ChannelRepository::class)->createChannel($trustedData);

        return response()->json([
            'message' => 'Channel created successfully'
        ],201);
    }

    /**
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOneChannel(string $slug)
    {
        return response()->json(
            Channel::where('slug',$slug)->first(),
            200
        );
    }

    /**
     * @method GET
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllChannels()
    {
        return response()->json(
            Channel::all(),
            200
        );
    }

    public function delete()
    {

    }

    public function update()
    {

    }

}
