<?php

namespace App\Http\Requests\Answer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnswerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'=>'required_without_all:description,question_id,correct | string | unique:answers',
            'description'=> 'required_without_all:name,question_id,correct | string | max:255',
            'question_id' => 'required_without_all:name,description,correct | integer |exists:questions,id',
            'correct' => 'required_without_all:name,description,question_id | boolean',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
