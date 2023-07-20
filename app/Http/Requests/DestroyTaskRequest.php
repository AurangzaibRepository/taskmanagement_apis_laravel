<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DestroyTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'integer|exists:tasks',
        ];
    }
}
