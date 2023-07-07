<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UpdateTeamRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('team'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => 'integer|exists:teams',
            'code' => 'required|max:10|unique:teams,code,'.$this->route('team'),
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
            'integer' => ':attribute must be an integer',
            'id.exists' => 'Team not found',
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
