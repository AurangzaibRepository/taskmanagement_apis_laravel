<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowProjectRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'integer|exists:projects',
        ];
    }
}
