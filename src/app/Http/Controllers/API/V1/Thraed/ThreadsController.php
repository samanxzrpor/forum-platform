<?php

namespace App\Http\Controllers\API\V1\Thraed;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use App\Repositories\ThreadRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ThreadsController extends Controller
{

    /**
     * Get All Thread That is Not Block
     * @method GET
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $threads = Thread::whereBlock(0)->latest()->get();
        return response()->json(
            $threads
        ,Response::HTTP_OK);
    }


    /**
     * Get One Thread With Slug Or ID Or Name
     * @method POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $thread = resolve(ThreadRepository::class)->getThread($request->toArray());

        return response()->json(
            $thread
        , Response::HTTP_OK);
    }

    public function update()
    {

    }

}
