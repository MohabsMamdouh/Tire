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
}
