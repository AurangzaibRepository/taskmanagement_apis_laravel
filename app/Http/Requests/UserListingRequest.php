<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UserListingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'page_number' => 'required|integer',
            'email' => 'nullable|email',
            'team_id' => 'nullable|integer|exists:teams,id',
            'department_id' => 'nullable|integer|exists:departments,id',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute is required',
            'integer' => ':attribute must be an integer',
            'email.email' => 'Invalid email',
            'team_id.exists' => 'Team not found',
            'department_id.exists' => 'Department not found',
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
