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
            'email' => 'required|email',
            'phone_number' => 'required',
            'password' => 'required',
            'team_id' => 'required|integer|exists:team,id',
            'department_id' => 'required|integer|exists:departments,id',
            'picture' => 'nullable|image',
            'role' => [new Enum(UserRoleEnum::class)],
        ];
    }
}
