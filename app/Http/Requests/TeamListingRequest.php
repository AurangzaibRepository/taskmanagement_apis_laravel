<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class TeamListingRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'page_number' => $this->route('pageNumber'),
        ]);
    }

    public function rules(): array
    {
        return [
            'page_number' => 'integer',
        ];
    }

    public function messages(): array
    {
        return [
            'integer' => ':attribute must be an integer',
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
