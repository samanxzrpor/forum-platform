<?php

namespace App\Repositories;

use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadRepository
{

    /**
     * @param array $request
     * @return mixed
     */
    public function getThread(array $request)
    {
        $fieldThatSearched = array_key_first($request);
        return Thread::where($fieldThatSearched, $request[$fieldThatSearched])->whereBlock(0)->first();
    }
}
