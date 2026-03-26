<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Rules;

use Illuminate\Support\Collection;
use NetworkRailBusinessSystems\Common\Rules\StringNotIn;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class StringNotInTest extends TestCase
{
    protected StringNotIn $rule;

    public function testPassesInsensitive(): void
    {
        $this->rule = new StringNotIn(['a', 'B', 'c']);

        $this->assertRulePasses(
            $this->rule,
            'name',
            'd',
        );
    }

    public function testPassesSensitive(): void
    {
        $this->rule = new StringNotIn(['a', 'B', 'c'], false);

        $this->assertRulePasses(
            $this->rule,
            'name',
            'b',
        );
    }

    public function testFailsInsensitive(): void
    {
        $this->rule = new StringNotIn(
            new Collection(['a', 'B', 'c']),
        );

        $this->assertRuleFails(
            $this->rule,
            'name',
            'b',
            'Enter :attribute which is not one of: a, B, c',
        );
    }

    public function testFailsSensitive(): void
    {
        $this->rule = new StringNotIn(
            new Collection(['a', 'B', 'c']),
            false,
        );

        $this->assertRuleFails(
            $this->rule,
            'name',
            'B',
            'Enter :attribute which is not one of: a, B, c',
        );
    }

    public function testNonStrings(): void
    {
        $this->rule = new StringNotIn([null, 1, true, [], new Collection()]);

        $this->assertRuleFails(
            $this->rule,
            'name',
            1,
            'Enter :attribute which is not one of: 1, []',
        );
    }
}
