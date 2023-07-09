<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteProjectRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('project'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => 'integer|exists:projects',
        ];
    }

    public function messages(): array
    {
        return [
            'integer' => ':attribute must be an integer',
            'id.exists' => 'Project not found',
        ];
    }
}
