<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class StoreProjectRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => 'required|max:10|unique:projects',
            'name' => 'required|max:100',
            'description' => 'required',
            'team_id' => 'required|integer|exists:teams,id',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute is required',
            'integer' => ':attribute must be an integer',
            'code.max' => 'code must not be greater than 10 characters',
            'name.max' => 'name must not be greater than 100 characters',
            'team_id.exists' => 'Team not found',
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
