<?php

namespace App\Http\Controllers\API\V1\Thraed;

use App\Http\Controllers\Controller;
use App\Http\Requests\Threads\StoreThreadRequest;
use App\Http\Requests\Threads\UpdateThreadRequest;
use App\Models\Thread;
use App\Repositories\ThreadRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $thread = resolve(ThreadRepository::class)->getThread($request);

        return response()->json(
            $thread
        , Response::HTTP_OK);
    }


    /**
     * Store New Thread in Database
     * @method POST
     * @param StoreThreadRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreThreadRequest $request)
    {
        $trustedData = $request->validated();

        $thread = resolve(ThreadRepository::class)->storeThread($trustedData);

        return response()->json([
            'message' => 'Thread created successfully'
        ], Response::HTTP_CREATED);
    }


    /**
     * @method PUT
     * @param UpdateThreadRequest $request
     * @return void
     */
    public function update(UpdateThreadRequest $request)
    {
        $trustedData = $request->validated();

        Thread::find($trustedData['id'])->update([
            'title' => $trustedData['title'],
        ]);
    }


    public function delete(Request $request)
    {
        Thread::findOrFail($request->input('id'))->delete();

        return response()->json([
            'message' => 'Deleted created successfully'
        ], Response::HTTP_OK);
    }

}
