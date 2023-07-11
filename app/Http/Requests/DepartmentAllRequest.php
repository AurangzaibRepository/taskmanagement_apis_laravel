<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentAllRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'teamId' => 'integer|exists:teams,id',
        ];
    }
}
