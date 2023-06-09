<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Foundation\Http\FormRequest;

class QuizRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'number_of_questions'=>['sometimes','integer'],
            'training_category_id'=>['required'],
            'training_type_id'=>['required']
        ];
    }
}
