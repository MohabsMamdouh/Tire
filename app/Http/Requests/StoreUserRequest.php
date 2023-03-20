<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth; 


class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('create user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'fname' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|min:4|Unique:users',
            'phone' => 'required|string',
            'password' => 'required|string|min:8',
            'roles' => 'required',
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
            'email.required' => 'Email is required!',
            'email.unique'  => 'This email is in use! Try another one.',

            'fname.required' => 'Name is required!',
            'fname.max' => 'Name can not have over 50 character!',

            'username.required' => 'Username is required!',
            'username.unique'  => 'This username is in use! Try another one.',
            'username.min'  => 'username must have at least 4 character.',

            'pasword.required' => 'Password is required!',
            'password.min'  => 'Password must have at least 8 character',

            'phone.required' => 'Phone is required!',

            'roles.required' => 'Roles is required!',
        ];
    }
}
