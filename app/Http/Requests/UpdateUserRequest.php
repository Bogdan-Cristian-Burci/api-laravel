<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'first_name' => 'sometimes | required|string|max:255',
            'last_name' => 'sometimes | required|string|max:255',
            'phone'=>'sometimes | required',
            'icon_number'=>'sometimes | required',
            'street'=>'sometimes | required',
            'street_additional'=>'sometimes | required',
            'county'=>'sometimes | required',
            'city'=>'sometimes | required'
        ];
    }
}
