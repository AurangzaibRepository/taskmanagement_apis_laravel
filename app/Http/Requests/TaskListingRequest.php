<?php

namespace App\Http\Requests;

use App\Enums\TaskStatusEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Http\JsonResponse;

class TaskListingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'project_id' => 'integer|exists:projects,id',
            'category_id' => 'integer|exists:categories,id',
            'user_id' => 'integer|exists:users,id',
            'status' => [new Enum(TaskStatusEnum::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'integer' => ':attribute must be an integer',
            'project_id.exists' => 'Project not found',
            'category_id.exists' => 'Category not found',
            'user_id.exists' => 'User not found',
            'status' => 'Invalid status',
        ];
    }
}
