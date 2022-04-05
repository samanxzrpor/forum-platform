<?php

namespace App\Http\Controllers\API\V1\Thread;

use App\Http\Controllers\Controller;
use App\Http\Requests\Threads\StoreAnswerRequest;
use App\Http\Requests\Threads\UpdateAnswerRequest;
use App\Models\Answer;
use App\Models\Subscribe;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\NewReplayThread;
use App\Repositories\AnswerRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

class AnswersContrller extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Answer::all() , Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAnswerRequest $request
     * @return JsonResponse
     */
    public function store(StoreAnswerRequest $request): JsonResponse
    {
        $trustedData = $request->validated();
        $answer = resolve(AnswerRepository::class)->storeAnswer($trustedData);

        # Get All Users That Subscribe Received Thread And Send Notification For Them
        resolve(UserRepository::class)->sendNotification($trustedData['thread_id']);

        return response()->json([
            'message' => 'Answer created successfully'
        ], Response::HTTP_CREATED);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAnswerRequest $request
     * @param Answer $answer
     * @return JsonResponse
     */
    public function update(UpdateAnswerRequest $request, Answer $answer): JsonResponse
    {
        $trustedData = $request->validated();

        if (!Gate::forUser(Auth::user())->allows('manage-answers',$answer))
            return response()->json(['message' => 'You are not allowed to update answers'] , Response::HTTP_FORBIDDEN);

        resolve(AnswerRepository::class)->updateAnswers($answer, $trustedData);

        return response()->json([
            'message' => 'Answer Update successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Answer  $answer
     * @return JsonResponse
     */
    public function destroy(Answer $answer): JsonResponse
    {
        if (!Gate::forUser(Auth::user())->allows('manage-answers',$answer))
            return response()->json(['message' => 'You are not allowed to delete answers'] , Response::HTTP_FORBIDDEN);

        $answer->delete();
        return response()->json(['message' => 'Answer deleted successfully'] , Response::HTTP_OK);
    }

}
