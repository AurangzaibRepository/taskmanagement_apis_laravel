<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentListingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'page_number' => 'required|integer',
            'team_id' => 'integer|exists:teams,id',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute is required',
            'integer' => ':attribute must be an integer',
            'team_id.exists' => 'Team not found',
        ];
    }
}
