<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowTeamRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'integer|exists:teams',
        ];
    }

    public function messages(): array
    {
        return [
            'integer' => ':attribute must be an integer',
            'id.exists' => 'Team not found',
        ];
    }
}
