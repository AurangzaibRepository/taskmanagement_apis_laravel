<?php

namespace App\Http\Requests;

use App\Enums\UserRoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required',
            'password' => 'required',
            'team_id' => 'required|integer|exists:team,id',
            'department_id' => 'required|integer|exists:departments,id',
            'picture' => 'nullable|image',
            'role' => [new Enum(UserRoleEnum::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute is required',
            'max' => ':attribute must not be greater than 50 characters',
            'email' => 'Invalid email',
            'email.unique' => 'Email aready exists',
            'team_id.exists' => 'Team not found',
            'department_id.exists' => 'Department not found',
            'image' => 'picture must be an image file',
            'role' => 'Invalid role',
        ];
    }
}
