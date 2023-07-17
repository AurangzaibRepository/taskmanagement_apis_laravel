<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserListingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'page_number' => 'integer',
            'email' => 'nullable|email',
            'team_id' => 'nullable|integer|exists:teams,id',
            'department_id' => 'nullable|integer|exists:departments,id',
        ];
    }
}
