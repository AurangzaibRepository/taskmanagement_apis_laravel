<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UserAllRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'teamId' => $this->route('teamId'),
            'departmentId' => $this->route('departmentId'),
        ]);
    }

    public function rules(): array
    {
        return [
            'teamId' => 'integer|exists:teams,id',
            'departmentId' => 'integer|exists:departments,id',
        ];
    }

    public function messages(): array
    {
        return [
            'integer' => ':attribute must be an integer',
            'teamId.exists' => 'Team not found',
            'departmentId.exists' => 'Department not found',
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
