<?php

namespace NetworkRailBusinessSystems\Common\Tests\Data;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\Traits\HasFormatters;

class Formatter
{
    use HasFormatters;

    public static function checkValue(string $format): string|array|null
    {
        $formatter = new Formatter();

        $person = new User();
        $person->name = 'Hello';
        $person->email = 'There';

        return match ($format) {
            'count' => $formatter->formatCount(new Collection([1, 2, 3]), 'penguin'),
            'currency' => $formatter->formatCurrency(12),
            'date' => $formatter->formatDate(Carbon::create(2026, 12, 13)),
            'person' => $formatter->formatPerson($person),
            'prefix' => $formatter->formatPrefix('123', '#'),
            'suffix' => $formatter->formatSuffix(12, '%'),
            'text' => $formatter->formatText("My\nText"),
            default => null,
        };
    }

    public static function checkBlank(string $format): string|array|null
    {
        $formatter = new Formatter();

        return match ($format) {
            'count' => $formatter->formatCount(null, 'penguin'),
            'currency' => $formatter->formatCurrency(null),
            'date' => $formatter->formatDate(null),
            'person' => $formatter->formatPerson(null),
            'prefix' => $formatter->formatPrefix(null, '#'),
            'suffix' => $formatter->formatSuffix(null, '%'),
            'text' => $formatter->formatText(null),
            default => null,
        };
    }
}
