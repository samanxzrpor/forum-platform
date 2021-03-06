<?php

namespace App\Http\Controllers\API\V1\Thread;

use App\Http\Controllers\Controller;
use App\Http\Requests\Threads\StoreThreadRequest;
use App\Http\Requests\Threads\UpdateThreadRequest;
use App\Models\Thread;
use App\Repositories\ThreadRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
     * @param string $slug
     * @return JsonResponse
     */
    public function show(string $slug): JsonResponse
    {
        $thread = resolve(ThreadRepository::class)->getThread($slug);

        return response()->json(
            $thread
        , Response::HTTP_OK);
    }


    /**
     * Store New Thread in Database
     * @method POST
     * @param StoreThreadRequest $request
     * @return JsonResponse
     */
    public function store(StoreThreadRequest $request): JsonResponse
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
     * @param Thread $thread
     * @return JsonResponse
     */
    public function update(UpdateThreadRequest $request ,Thread $thread): JsonResponse
    {
        $trustedData = $request->validated();

        if (!Gate::forUser(Auth::user())->allows('manage-thread' , $thread))
            return response()->json(['message' => 'You are not allowed to update'] , Response::HTTP_FORBIDDEN);

        resolve(ThreadRepository::class)->updateThread($thread, $trustedData);

        return response()->json([
            'message' => 'Thread updated successfully',
        ], 200);
    }


    public function delete(int $id): JsonResponse
    {
        $thread = Thread::findOrFail($id);

        if (!Gate::forUser(Auth::user())->allows('manage-thread' , $thread))
            return response()->json(['message' => 'You are not allowed to update'] , Response::HTTP_FORBIDDEN);

        $thread->delete();

        return response()->json([
            'message' => 'Deleted created successfully'
        ], Response::HTTP_OK);
    }

}
