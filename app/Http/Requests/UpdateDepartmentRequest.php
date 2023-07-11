<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'integer|exists:departments',
            'name' => 'required|max:100',
            'description' => 'required',
            'team_id' => 'required|integer|exists:teams,id',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute is required',
            'integer' => ':attribute must be an integer',
            'name.max' => 'name must not be greater than 100 characters',
            'team_id.exists' => 'Team not found',
        ];
    }
}
