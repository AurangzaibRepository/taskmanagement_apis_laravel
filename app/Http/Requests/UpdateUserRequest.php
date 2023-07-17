<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
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
}
