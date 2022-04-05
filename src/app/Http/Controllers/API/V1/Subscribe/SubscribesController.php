<?php

namespace App\Http\Controllers\API\V1\Subscribe;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use App\Models\Thread;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class SubscribesController extends Controller
{

    /**
     * @param Thread $thread
     * @return JsonResponse
     */
    public function subscribe(Thread $thread): JsonResponse
    {
        # Subscribe Posted Thread For Current User
        $sub = Auth::user()->subscribes()->firstOrCreate([
            'thread_id' => $thread->id
        ]);

        return response()->json([
            'message' => 'Thread Subscribe successfully',
            'sub' => $sub
        ] , Response::HTTP_CREATED);
    }

    /**
     * @param Thread $thread
     * @return JsonResponse
     */
    public function unsubscribe(Thread $thread): JsonResponse
    {
        # Unsubscribe Posted Thread For Current User
        Auth::user()->subscribes()->where('thread_id' , $thread->id)->delete();

        return response()->json([
            'message' => 'Thread Unsubscribe successfully',
        ] , Response::HTTP_OK);
    }
}
