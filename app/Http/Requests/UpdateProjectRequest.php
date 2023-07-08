<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UpdateProjectRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('project'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => 'integer|exists:projects',
            'code' => 'required|max:10,unique:projects,code,'.$this->route('code'),
            'name' => 'required|max:100',
            'description' => 'required',
            'team_id' => 'required|integer|exists:teams,id',
        ];
    }

    public function messages(): array
    {
        return [
            'integer' => ':attribute must be an integer',
            'required' => ':attribute is required',
            'code.max' => 'code must not be greater than 10 characters',
            'code.unique' => 'code already exists',
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
