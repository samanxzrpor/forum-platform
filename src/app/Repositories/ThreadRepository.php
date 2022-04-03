<?php

namespace App\Repositories;

use App\Models\Thread;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ThreadRepository
{

    /**
     * @param array $request
     * @return mixed
     */
    public function getThread(Request $request)
    {
        $fieldThatSearched = array_key_first($request->input());
        return Thread::where($fieldThatSearched, $request->input($fieldThatSearched))->whereBlock(0)->first();
    }

    /**
     * @param mixed $trustedData
     * @return void
     */
    public function storeThread(mixed $trustedData)
    {
        return Thread::create([
            'title' => $trustedData['title'],
            'slug' => Str::slug($trustedData['title']),
            'body' => $trustedData['body'],
            'channel_id' => $trustedData['channel_id'],
            'user_id' => Auth::user()->id
        ]);
    }

    /**
     * @param Thread $thread
     * @param mixed $trustedData
     * @return mixed
     */
    public function updateThread(Thread $thread, mixed $trustedData)
    {
        $title = $trustedData['title'] ?? $thread->title;

        $thread->update([
            'title' => $title ,
            'slug' => Str::slug($title),
            'channel_id' => $trustedData['channel_id'] ?? $thread->channel_id,
            'body' => $trustedData['body'] ?? $thread->body,
            'best_answer_id' => $trustedData['best_answer_id'] ?? $thread->best_answer_id ,
        ]);
    }
}
