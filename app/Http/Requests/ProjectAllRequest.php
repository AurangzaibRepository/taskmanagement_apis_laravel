<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectAllRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'teamId' => $this->route('teamId'),
        ]);
    }

    public function rules(): array
    {
        return [
            'teamId' => 'integer|exists:teams,id',
        ];
    }

    public function messages(): array
    {
        return [
            'integer' => ':attribute must be an integer',
            'teamId.exists' => 'Team not found',
        ];
    }
}
