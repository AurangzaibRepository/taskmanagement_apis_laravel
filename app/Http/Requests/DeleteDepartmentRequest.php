<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpJsonException;
use Illuminate\Http\JsonResponse;

class DeleteDepartmentRequest extends FormRequest
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

    protected function failedValidation(Validator $validator): JsonResponse
    {
        throw new HttpJsonException(getResponse(
            false,
            $validator->messages()->all(),
        ));
    }
}
