<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerApiRequest extends FormRequest
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
            'customerFname' => 'required|string|max:50',
            'customerAddress' => 'required|string',
            'customerUsername' => 'required|string|min:4|Unique:customers,customer_username',
            'customerPhone' => 'required|string',
            'password' => 'required|string|min:8',
            'email' => 'required|string|email|unique:customers,email',
            'roles' => 'required',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'customer_fname' => $this->customerFname,
            'customer_address' => $this->customerAddress,
            'customer_username' => $this->customerUsername,
            'customer_phone' => $this->customerPhone,
        ]);
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