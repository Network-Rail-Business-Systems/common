<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Traits\Role;

use NetworkRailBusinessSystems\Common\Tests\Enums\Role;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class ValuesTest extends TestCase
{
    public function test(): void
    {
        $this->assertEquals(
            [
                Role::Admin->value,
                Role::Other->value,
                Role::User->value,
            ],
            Role::values(),
        );
    }
}
