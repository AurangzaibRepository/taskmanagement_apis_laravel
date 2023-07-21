<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskListingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'project_id' => 'integer|exists:projects,id',
            'category_id' => 'integer|exists:categories,id',
            'user_id' => 'integer|exists:users,id',
        ];
    }
}
