<?php

namespace App\Http\Requests;

use App\Rules\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users',
            'password' => ['required', new PasswordRule($this->email)],
            'new_password' => 'required',
        ];
    }

    public function messages(): void
    {
        return [
            'required' => ':attribute is required',
            'email.email' => 'Invalid email',
            'email.exists' => 'Email not found',
        ];
    }
}
