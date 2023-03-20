<?php

namespace App\Http\Requests\Customer;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'customer_fname' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(Customer::class)->ignore(Auth::guard('customer')->user()->id)],
            'customer_address' => 'required|string',
            'customer_phone' => 'required|string',
        ];
    }
}