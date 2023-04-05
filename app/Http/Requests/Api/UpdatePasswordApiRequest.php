<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordApiRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8|same:password',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'password.required' => 'Password is required!',
            'password.min'  => 'Password must have at least 8 character',

            'password_confirmation.required' => 'Password is required!',
            'password_confirmation.same' => 'The password confirm and password must match.',
            'password_confirmation.min'  => 'Password must have at least 8 character',
        ];
    }
}