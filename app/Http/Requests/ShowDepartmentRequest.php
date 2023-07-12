<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowDepartmentRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('department'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => 'integer|exists:departments',
        ];
    }

    public function messages(): array
    {
        return [
            'integer' => ':attribute must be an integer',
            'id.exists' => 'Department not found',
        ];
    }
}
