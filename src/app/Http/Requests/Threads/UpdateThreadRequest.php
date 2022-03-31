<?php

namespace App\Http\Requests\Threads;

use Illuminate\Foundation\Http\FormRequest;

class UpdateThreadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer',
            'title' => 'nullable|min:10',
            'body' => 'nullable|min:10',
            'channel_id' => 'required|integer'
        ];
    }
}
