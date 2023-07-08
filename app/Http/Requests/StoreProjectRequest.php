<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => 'required|max:10',
            'name' => 'required|max:100',
            'description' => 'required',
            'team_id' => 'required|integer|exists:teams,id',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute is required',
            'code.max' => 'code must not be greater than 10 characters',
            'name.max' => 'name must not be greater than 100 characters',
            'team.exists' => 'Team not found',
        ];
    }
}
