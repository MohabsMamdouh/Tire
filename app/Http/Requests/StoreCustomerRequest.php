<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('create customer');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'customer_fname' => 'required|string|max:50',
            'customer_address' => 'required|string',
            'customer_username' => 'required|string|min:4|Unique:customers',
            'customer_phone' => 'required|string',
            'password' => 'required|string|min:8',
            'email' => 'required|string|email|unique:customers,email',
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
            'customer_email.required' => 'Email is required!',
            'customer_email.unique'  => 'This email is in use! Try another one.',

            'customer_address.required' => 'Address is required!',

            'customer_fname.required' => 'Name is required!',
            'customer_fname.max' => 'Name can not have over 50 character!',

            'customer_username.required' => 'Username is required!',
            'customer_username.unique'  => 'This username is in use! Try another one.',
            'customer_username.min'  => 'username must have at least 4 character.',

            'password.required' => 'Password is required!',
            'password.min'  => 'Password must have at least 8 character',

            'customer_phone.required' => 'Phone is required!',

            'roles.required' => 'Roles is required!',
        ];
    }
}
