<?php

namespace NetworkRailBusinessSystems\Common\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class StringDifferent implements ValidationRule, DataAwareRule
{
    protected array $data = [];

    public function __construct(
        public string $other,
        public bool $insensitive = true,
    ) {
        //
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $needle = $this->data[$this->other] ?? null;

        if (is_array($needle) === true) {
            return;
        }

        if (Str::is($needle, $value, $this->insensitive) === true) {
            $other = Str::of($this->other)
                ->snake()
                ->replace(['_', '-'], ' ');

            $fail("Enter a different :attribute than $other");
        }
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }
}
