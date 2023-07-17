<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowUserRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('user'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => 'integer|exists:users',
        ];
    }

    public function messages(): array
    {
        return [
            'integer' => ':attribute must be an inetger',
            'id.exists' => 'User not found',
        ];
    }
}
