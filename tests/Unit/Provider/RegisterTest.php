<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Provider;

use NetworkRailBusinessSystems\Common\Tests\TestCase;

class RegisterTest extends TestCase
{
    public function test(): void
    {
        $this->assertEquals(
            '/home',
            config('common.home'),
        );
    }
}
