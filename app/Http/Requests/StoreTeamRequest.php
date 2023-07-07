<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class StoreTeamRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => 'required|max:10|unique:teams',
            'name' => 'required|max:100',
            'description' => 'required',
            'logo_file' => 'nullable|image',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute is required',
            'unique' => ':attribute already exists',
            'code.max' => 'code must not be greater than 10 characters',
            'name.max' => 'name must not be greater than 100 characters',
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
