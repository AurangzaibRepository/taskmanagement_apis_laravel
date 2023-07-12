<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteDepartmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'integer|exists:departments',
        ];
    }
}
