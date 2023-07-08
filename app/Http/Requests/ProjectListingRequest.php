<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectListingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'pageNumber' => 'integer',
            'team_id' => 'nullable|integer|exists:teams,id',
        ];
    }
}
