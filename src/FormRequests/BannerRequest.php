<?php

namespace NetworkRailBusinessSystems\Common\FormRequests;

use AnthonyEdmonds\GovukLaravel\Rules\Dates\DateFormat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use NetworkRailBusinessSystems\Common\Controllers\BannerController;

class BannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => [
                'required',
                'string',
                Rule::in(BannerController::BANNER_TYPES),
            ],
            'title' => [
                'required',
                'string',
            ],
            'message' => [
                'required',
                'string',
            ],
            'ends_at' => [
                'nullable',
                Rule::when(
                    $this->input('ends_at-day') !== null,
                    new DateFormat(),
                ),
            ],
        ];
    }
}
