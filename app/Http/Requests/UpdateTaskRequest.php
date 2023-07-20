<?php

namespace App\Http\Requests;

use App\Enums\TaskStatusEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules\Enum;

class UpdateTaskRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('task'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => 'integer|exists:tasks',
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
            'id.exists' => 'Task not found',
            'title.max' => 'title must not be greater than 80 characters',
            'project_id.exists' => 'Project not found',
            'category_id.exists' => 'Category not found',
            'user_id.exists' => 'User not found',
            'status' => 'Invalid status',
        ];
    }

    public function failedValidation(Validator $validator): JsonResponse
    {
        throw new HttpResponseException(getResponse(
            false,
            $validator->messages()->all(),
        ));
    }
}
