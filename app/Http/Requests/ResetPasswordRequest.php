<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users',
            'code' => 'required|exists:users,code,email'.$this->email,
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute is required',
            'email.email' => 'Invalid email',
            'email.exists' => 'email not found',
            'code.exists' => 'Invalid code',
        ];
    }
}
