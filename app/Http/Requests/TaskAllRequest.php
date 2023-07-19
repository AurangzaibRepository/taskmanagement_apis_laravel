<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskAllRequest extends FormRequest
{
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
