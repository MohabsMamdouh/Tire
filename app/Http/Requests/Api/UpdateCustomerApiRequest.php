<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerApiRequest extends FormRequest
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
        $method = $this->method();

        if ($method == 'PUT') {
            return [
                'customerFname' => 'required|string|max:50',
                'customerAddress' => 'required|string',
                'customerUsername' => 'required|string|min:4|Unique:customers,customer_username',
                'customerPhone' => 'required|string',
                'password' => 'required|string|min:8',
                'email' => 'required|string|email|unique:customers,email',
                'roles' => 'required',
            ];
        } else {
            return [
                'customerFname' => 'sometimes|required|string|max:50',
                'customerAddress' => 'sometimes|required|string',
                'customerUsername' => 'sometimes|required|string|min:4|Unique:customers,customer_username',
                'customerPhone' => 'sometimes|required|string',
                'password' => 'sometimes|required|string|min:8',
                'email' => 'sometimes|required|string|email|unique:customers,email',
                'roles' => 'sometimes|required',
            ];
        }
    }

    protected function prepareForValidation()
    {
        if ($this->customerFname) {
            $this->merge([
                'customer_fname' => $this->customerFname
            ]);
        }

        if ($this->customerAddress) {
            $this->merge([
                'customer_address' => $this->customerAddress
            ]);
        }

        if ($this->customerUsername) {
            $this->merge([
                'customer_username' => $this->customerUsername
            ]);
        }
        if ($this->customer_phone) {
            $this->merge([
                'customer_phone' => $this->customerPhone
            ]);
        }
    }
}