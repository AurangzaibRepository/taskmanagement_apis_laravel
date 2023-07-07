<?php

namespace App\Http\Requests;

use App\Enums\CategoryStatusEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules\Enum;

class CategoryStatusRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id'),
            'status' => $this->route('status'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => 'integer|exists:categories',
            'status' => [new Enum(CategoryStatusEnum::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'integer' => ':attribute must be an integer',
            'exists' => ':attribute not found',
            'Illuminate\Validation\Rules\Enum' => 'Invalid :attribute',
        ];
    }

    protected function failedValidation(Validator $validator): JsonResponse
    {
        throw new HttpResponseException(getResponse(
            false,
            $validator->messages()->all(),
        ));
    }
}
