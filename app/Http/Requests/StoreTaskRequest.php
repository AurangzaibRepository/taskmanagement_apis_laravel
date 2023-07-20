<?php

namespace App\Http\Requests;

use App\Enums\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|max:80',
            'description' => 'required',
            'project_id' => 'required|integer|exists:projects,id',
            'category_id' => 'required|integer|exists:categories,id',
            'user_id' => 'required|integer|exists:users,id',
            'status' => [new Enum(TaskStatusEnum::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute is required',
            'integer' => ':attribute must be an integer',
            'title.max' => 'title must not be greater than 80 characters',
            'project_id.exists' => 'Project not found',
            'category_id.exists' => 'Category not found',
            'user_id.exists' => 'User not found',
            'status' => 'Invalid status',
        ];
    }
}
