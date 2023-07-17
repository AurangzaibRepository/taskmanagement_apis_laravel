<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class StoreUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|unique:users|ends_with:gmail.com,laravel.com',
            'phone_number' => 'required',
            'password' => 'required',
            'team_id' => 'required|integer|exists:teams,id',
            'department_id' => 'required|integer|exists:departments,id',
            'picture' => 'nullable|image',
            'role' => 'required|in:Admin,User',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute is required',
            'integer' => ':attribute must be an integer',
            'max' => ':attribute must not be greater than 50 characters',
            'email.email' => 'Invalid email',
            'email.unique' => 'Email aready exists',
            'team_id.exists' => 'Team not found',
            'department_id.exists' => 'Department not found',
            'image' => 'picture must be an image file',
            'role' => 'Invalid role',
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
