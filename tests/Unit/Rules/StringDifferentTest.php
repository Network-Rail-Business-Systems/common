<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Rules;

use Illuminate\Support\Collection;
use NetworkRailBusinessSystems\Common\Rules\StringDifferent;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class StringDifferentTest extends TestCase
{
    protected StringDifferent $rule;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rule = new StringDifferent('other-field');

        $this->rule->setData([
            'other-field' => 'D',
        ]);
    }

    public function testPassesInsensitive(): void
    {
        $this->assertRulePasses(
            $this->rule,
            'name',
            'b',
        );
    }

    public function testPassesSensitive(): void
    {
        $this->rule->insensitive = false;

        $this->assertRulePasses(
            $this->rule,
            'name',
            'd',
        );
    }

    public function testFailsInsensitive(): void
    {
        $this->assertRuleFails(
            $this->rule,
            'name',
            'd',
            'Enter a different :attribute than other field',
        );
    }

    public function testFailsSensitive(): void
    {
        $this->rule->insensitive = false;

        $this->assertRuleFails(
            $this->rule,
            'name',
            'D',
            'Enter a different :attribute than other field',
        );
    }

    public function testNull(): void
    {
        $this->rule->setData([
            'other-field' => null,
        ]);

        $this->assertRuleFails(
            $this->rule,
            'name',
            null,
            'Enter a different :attribute than other field',
        );
    }

    public function testArray(): void
    {
        $this->rule->setData([
            'other-field' => [],
        ]);

        $this->assertRulePasses(
            $this->rule,
            'name',
            [],
        );
    }

    public function testInteger(): void
    {
        $this->rule->setData([
            'other-field' => 1,
        ]);

        $this->assertRulePasses(
            $this->rule,
            'name',
            2,
        );
    }

    public function testObject(): void
    {
        $this->rule->setData([
            'other-field' => new Collection(),
        ]);

        $this->assertRulePasses(
            $this->rule,
            'name',
            new Collection(),
        );
    }
}
