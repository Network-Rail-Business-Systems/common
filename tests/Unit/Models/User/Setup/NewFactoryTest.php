<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Models\User\Setup;

use NetworkRailBusinessSystems\Common\Factories\UserFactory;
use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class NewFactoryTest extends TestCase
{
    public function test(): void
    {
        $this->assertInstanceOf(
            UserFactory::class,
            User::factory(),
        );
    }
}
