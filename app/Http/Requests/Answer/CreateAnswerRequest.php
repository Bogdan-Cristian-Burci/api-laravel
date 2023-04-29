<?php

namespace App\Http\Requests\Answer;

use Illuminate\Foundation\Http\FormRequest;

class CreateAnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'=>'required | string | unique:answers',
            'description'=> 'required | string | max:255',
            'question_id' => 'required | integer |exists:questions,id'
        ];
    }
}
