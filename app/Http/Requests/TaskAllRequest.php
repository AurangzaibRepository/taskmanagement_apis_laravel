<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
}
