<?php

namespace App\Http\Requests;

use App\Enums\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

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
}
