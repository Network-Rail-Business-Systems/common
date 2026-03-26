<?php

namespace NetworkRailBusinessSystems\Common\Rules;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class StringNotIn implements ValidationRule
{
    protected bool $insensitive = true;

    protected array $needles = [];

    public function __construct(
        Arrayable|array $needles,
        bool $insensitive = true,
    ) {
        if (is_a($needles, Arrayable::class) === true) {
            $needles = $needles->toArray();
        }

        foreach ($needles as $needle) {
            if (
                $needle === null
                || is_array($needle) === true
            ) {
                continue;
            }

            $needle = (string) $needle;
            $this->needles[$needle] = $needle;
        }

        $this->insensitive = $insensitive;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Str::is($this->needles, $value, $this->insensitive) === true) {
            $fail('Enter :attribute which is not one of: ' . implode(', ', $this->needles));
        }
    }
}
