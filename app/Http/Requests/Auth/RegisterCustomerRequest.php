<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Customer;
use Illuminate\Validation\Rules;


class RegisterCustomerRequest extends FormRequest
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
            'customer_fname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Customer::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'customer_address' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:255'],
        ];
    }
}