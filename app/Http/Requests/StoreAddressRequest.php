<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class StoreAddressRequest extends FormRequest
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
            'street_name' => 'required|string|max:50',
            'State_name' => 'required|string|max:50',
            'City_name' => 'required|string|max:50',
            'Country_name' => 'required|string|max:50',
            'zip_code' => 'required|integer|min:5',
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
            'street_name.required' => 'Street Name  is required!',
            'street_name.max' => 'Street Name can not have over 50 character!',

            'State_name.required' => 'State Name is required!',
            'State_name.max' => 'State Name can not have over 50 character!',

            'City_name.required' => 'City Name is required!',
            'City_name.max' => 'City Name can not have over 50 character!',

            'Country_name.required' => 'Country Name is required!',
            'Country_name.max' => 'Country Name can not have over 50 character!',

            'zip_code.required' => 'Zip Code  is required!',
            'zip_code.min' => 'Zip Code should have at least 5 numbers!',
        ];
    }
}