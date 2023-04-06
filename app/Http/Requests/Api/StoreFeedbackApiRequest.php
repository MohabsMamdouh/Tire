<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackApiRequest extends FormRequest
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
            'message' => 'required|string',
            'visitId' => 'required',
            'customerId' => 'required',
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
            'message.required' => 'Message Field is required!',

            'visitId.required' => 'Visit Field is required!',

            'customerId.required' => 'Customer Field is required!',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'customer_id' => $this->customerId,
            'visit_id' => $this->visitId,
        ]);
    }
}