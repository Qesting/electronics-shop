<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'emailAddress' => [
                'required',
                'string',
                'unique:users,email_address'
            ],
            'password' => [
                'required',
                'string',
                \Illuminate\Validation\Rules\Password::min(8)
                    ->numbers()
                    ->mixedCase()
                    //->uncompromised()
            ],
            'repeatPassword' => [
                'required',
                'string',
                'same:password'
            ]
        ];
    }
}
