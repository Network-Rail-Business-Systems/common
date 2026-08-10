<?php

namespace NetworkRailBusinessSystems\Common\FormRequests;

use Illuminate\Foundation\Http\FormRequest;
use NetworkRailBusinessSystems\DirectoryLink\Models\DirectoryUser;
use NetworkRailBusinessSystems\DirectoryLink\Rules\ExistsInDirectory;

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
                new ExistsInDirectory(DirectoryUser::class),
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
