<?php

namespace NetworkRailBusinessSystems\Common\FormRequests;

use Illuminate\Foundation\Http\FormRequest;
use NetworkRailBusinessSystems\Entra\Rules\UserExistsInEntra;

class ImportUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                new UserExistsInEntra(),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.*' => 'Enter the e-mail of a person with a Network Rail account',
        ];
    }
}
