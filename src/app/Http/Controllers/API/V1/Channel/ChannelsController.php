<?php

namespace App\Http\Controllers\API\V1\Channel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Channels\GetOneChannelRequest;
use App\Http\Requests\Channels\StoreChannelRequest;
use App\Http\Requests\Channels\UpdateChannelRequest;
use App\Models\Channel;
use App\Repositories\ChannelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ChannelsController extends Controller
{

    /**
     * @param StoreChannelRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreChannelRequest $request)
    {
        $trustedData = $request->validated();

        # Create New Channel in Database
        resolve(ChannelRepository::class)->createChannel($trustedData);

        return response()->json([
            'message' => 'Channel created successfully'
        ],Response::HTTP_CREATED);
    }


    /**
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        return response()->json(
            resolve(ChannelRepository::class)->getOneChannel($request->toArray())
        , Response::HTTP_OK);
    }


    /**
     * @method GET
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(
            Channel::all(),
            Response::HTTP_OK
        );
    }


    /**
     * @method DELETE
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        Channel::destroy($request->id);

        return response()->json([
                'message' => 'Channel deleted successfully'
            ], Response::HTTP_OK);
    }


    /**
     * Update Channels Data
     * @method PUT
     * @param UpdateChannelRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateChannelRequest $request)
    {
        $trustedData = $request->validated();

        resolve(ChannelRepository::class)->updateChannel($trustedData);

        return response()->json([
            'message' => 'Channels updated successfully'
        ], Response::HTTP_OK);
    }


}
