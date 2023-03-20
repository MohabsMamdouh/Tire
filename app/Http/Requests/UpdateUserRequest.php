<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('update user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = $this->request->get("id");

        return [
            'fname' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,'.$id,
            'username' => 'required|string|min:4|Unique:users,username,' . $id,
            'phone' => 'required|string',
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

            'phone.required' => 'Phone is required!',
            'roles.required' => 'Roles is required!',

        ];
    }
}