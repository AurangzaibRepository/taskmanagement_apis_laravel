<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'integer|exists:tasks',
            'title' => 'required|max:80',
            'description' => 'required',
            'project_id' => 'required|integer|exists:projects,id',
            'category_id' => 'required|integer|exists:categories,id',
            'user_id' => 'required|integer|exists:users,id',
        ];
    }
}
