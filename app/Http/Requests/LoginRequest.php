<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|exists:users',
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute is required',
            'email.exists' => 'Email not found',
        ];
    }
}
