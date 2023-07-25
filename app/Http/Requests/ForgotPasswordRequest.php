<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users',
        ];
    }

    public function messages(): array
    {
        return [
            'email.email' => 'Invalid email',
            'email.exists' => 'Email not found',
        ];
    }
}
