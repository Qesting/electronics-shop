<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserShippingDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstName' => [
                'required',
                'string'
            ],
            'lastName' => [
                'required',
                'string'
            ],
            'emailAddress' => [
                'required',
                'email'
            ],
            'phoneNumber' => [
                'nullable',
                'numeric'
            ],
            'address.country' => [
                'required',
                'string'
            ],
            'address.city' => [
                'required',
                'string'
            ],
            'address.postalCode' => [
                'required',
                'regex:/^\d{2}-\d{3}$/'
            ],
            'address.street' => [
                'required',
                'string'
            ],
            'address.building' => [
                'required',
                'numeric'
            ],
            'address.apartment' => [
                'nullable',
                'numeric'
            ]
        ];
    }
}
