<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResponsesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'quiz_question_id' => 'required | integer',
            'answer_id' => 'required | integer',
            'duration' => 'sometimes | integer',
        ];
    }
}
