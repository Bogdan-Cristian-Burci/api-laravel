<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Foundation\Http\FormRequest;

class QuizRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer'],
            'name' => ['required'],
            'number_of_questions'=>['sometimes','integer']
        ];
    }
}
