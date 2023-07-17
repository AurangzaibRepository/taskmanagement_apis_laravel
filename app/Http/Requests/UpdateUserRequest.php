<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class UpdateUserRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('user'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => 'integer|exists:users',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|unique:users|ends_with:gmail.com,laravel.com',
            'phone_number' => 'required',
            'password' => 'required',
            'team_id' => 'required|integer|exists:teams,id',
            'department_id' => 'required|integer|exists:departments,id',
            'image' => 'nullable|image',
            'role' => 'required|in:Admin,User',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute is required',
            'integer' => ':attribute must be an integer',
            'id.exists' => 'User not found',
            'max' => ':attribute must not be greater than 50 characters',
            'email.email' => 'Invalid email',
            'email.unique' => 'email aready exists',
            'email.ends_with' => 'email must be either from gmail or laravel domain',
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
