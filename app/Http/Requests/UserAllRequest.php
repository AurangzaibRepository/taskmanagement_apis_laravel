<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAllRequest extends FormRequest
{
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
}
