<?php

namespace NetworkRailBusinessSystems\Common\Traits;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

trait HasFormatters
{
    protected function formatCount(
        array|Arrayable|null $list,
        string $term,
        ?string $blank = null,
    ): ?string {
        if ($list === null) {
            return $blank;
        }

        if (is_a($list, Arrayable::class) === true) {
            $list = $list->toArray();
        }

        return Str::plural($term, count($list), true);
    }

    protected function formatCurrency(
        float|int|null $value,
        string $currency = 'GBP',
        ?string $blank = null,
    ): ?string {
        return $value !== null
            ? Number::currency($value, $currency)
            : $blank;
    }

    protected function formatDate(
        ?Carbon $date,
        string $format = 'd/m/Y H:i',
        string $timezone = 'Europe/London',
        ?string $blank = null,
    ): ?string {
        return $date !== null
            ? $date->timezone($timezone)->format($format)
            : $blank;
    }

    protected function formatPrefix(
        string|int|null $value,
        string $prefix,
        ?string $blank = null,
    ): ?string {
        return $value !== null
            ? "$prefix$value"
            : $blank;
    }

    protected function formatSuffix(
        string|int|null $value,
        string $suffix,
        ?string $blank = null,
    ): ?string {
        return $value !== null
            ? "$value$suffix"
            : $blank;
    }

    protected function formatText(
        ?string $text,
        ?string $blank = null,
    ): ?string {
        return empty($text) === false
            ? nl2br($text)
            : $blank;
    }
}
