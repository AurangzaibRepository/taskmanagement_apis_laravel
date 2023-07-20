<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class ShowTaskRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('task'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => 'integer|exists:tasks',
        ];
    }

    public function messages(): array
    {
        return [
            'integer' => ':attribute must be an integer',
            'id.exists' => 'Task not found',
        ];
    }
}
