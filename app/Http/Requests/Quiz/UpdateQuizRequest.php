<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuizRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required | string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
