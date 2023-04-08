<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVisitApiRequest extends FormRequest
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
                'customerId' => 'required|integer|exists:customers,id',
                'carModelId' => 'required|integer|exists:car_models,id',
                'userId' => 'required|integer|exists:users,id',
                'reason' => 'required',
            ];
        } else {
            return [
                'customerId' => 'sometimes|required|integer|exists:customers,id',
                'carModelId' => 'sometimes|required|integer|exists:car_models,id',
                'userId' => 'sometimes|required|integer|exists:users,id',
                'reason' => 'sometimes|required',
            ];
        }
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'customer_id' => $this->customerId,
            'car_model_id' => $this->carModelId,
            'user_id' => $this->userId,
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
            'customerId.required' => 'Customer is required!',
            'customerId.exists' => 'There is no Customer with that ID',
            'userId.unique'  => 'Mechanic is required',
            'userId.exists' => 'There is no user with that ID',
            'carModelId.unique'  => 'Car model is required',
            'carModelId.exists' => 'There is no car model with that ID',
            'reason.unique'  => 'reason is required',
        ];
    }
}
