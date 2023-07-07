<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ShowCategoryRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('category'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => 'integer|exists:categories',
        ];
    }

    public function messages(): array
    {
        return [
            'integer' => ':attribute must be an integer',
            'id.exists' => 'Category not found',
        ];
    }
}
