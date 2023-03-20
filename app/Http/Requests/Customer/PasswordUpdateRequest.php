<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;

class PasswordUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'current_password' => ['required', new MatchOldPassword],
            'password' => 'required|string|min:8',
            'password_confirmation' => ['same:password'],
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
            'current_password.required' => 'Password is required!',
            'password_confirmation.required' => 'Password is required!',
            'pasword.required' => 'Password is required!',
            'password.min'  => 'Password must have at least 8 character',
            'password_confirmation.same' => 'The password confirm and password must match.',

        ];
    }
}