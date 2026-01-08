<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use NetworkRailBusinessSystems\Common\Tests\TestCase;

class RegisterTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test(): void
    {
        $this->assertEquals(
            '/dashboard',
            config('common.home'),
        );
    }
}