<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class TaskAllRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'projectId' => $this->route('projectId'),
        ]);
    }

    public function rules(): array
    {
        return [
            'projectId' => 'integer|exists:projects,id',
        ];
    }

    public function messages(): array
    {
        return [
            'integer' => ':attribute must be an integer',
            'projectId.exists' => 'Project not found',
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
