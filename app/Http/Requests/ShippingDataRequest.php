<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingDataRequest extends FormRequest
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
            'shippingData.firstName' => [
                'required',
                'string'
            ],
            'shippingData.lastName' => [
                'required',
                'string'
            ],
            'shippingData.emailAddress' => [
                'required',
                'email'
            ],
            'shippingData.phoneNumber' => [
                'nullable',
                'numeric'
            ],
            'shippingData.address.country' => [
                'required',
                'string'
            ],
            'shippingData.address.city' => [
                'required',
                'string'
            ],
            'shippingData.address.postalCode' => [
                'required',
                'regex:/^\d{2}-\d{3}$/'
            ],
            'shippingData.address.street' => [
                'required',
                'string'
            ],
            'shippingData.address.building' => [
                'required',
                'numeric'
            ],
            'shippingData.address.apartment' => [
                'nullable',
                'numeric'
            ],
            'shippingMethod' => [
                'required',
                'numeric',
                'exists:shipping_methods,id'
            ],
            'paymentMethod' => [
                'required',
                'numeric',
                'exists:payment_methods,id'
            ]
        ];
    }
}
