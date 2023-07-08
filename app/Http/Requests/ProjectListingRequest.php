<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class ProjectListingRequest extends FormRequest
{
    public function prepareForValidation(): void
    {
        $this->merge([
            'team_id' => $this->route('teamId'),
        ]);
    }

    public function rules(): array
    {
        return [
            'pageNumber' => 'integer',
            'team_id' => 'nullable|integer|exists:teams,id',
        ];
    }

    public function messages(): array
    {
        return [
            'integer' => ':attribute must be an integer',
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
