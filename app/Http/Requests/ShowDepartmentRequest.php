<?php

namespace App\Http\Requests;

use Illuinate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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

    protected function failedValidation(Validator $validator): JsonResponse
    {
        throw new HttpResponseException(getResponse(
            false,
            $validator->messages()->all(),
        ));
    }
}
