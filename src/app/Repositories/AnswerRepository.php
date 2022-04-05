<?php

namespace App\Repositories;

use App\Models\Answer;
use App\Models\Thread;
use Illuminate\Support\Facades\Auth;

class AnswerRepository
{

    /**
     * @param mixed $trustedData
     * @return void
     */
    public function storeAnswer(mixed $trustedData)
    {
        return Answer::create([
            'body' => $trustedData['body'],
            'thread_id' => $trustedData['thread_id'],
            'user_id' => Auth::user()->id
        ]);
    }

    /**
     * @param Answer $answer
     * @param mixed $trustedData
     * @return void
     */
    public function updateAnswers(Answer $answer, mixed $trustedData): void
    {
        $answer->update([
            'body' => $trustedData['body'],
            'thread_id' => $trustedData['thread_id'],
            'user_id' => Auth::user()->id
        ]);
    }
}
