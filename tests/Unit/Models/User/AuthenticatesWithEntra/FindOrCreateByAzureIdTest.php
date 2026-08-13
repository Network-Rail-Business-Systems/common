<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Models\User\AuthenticatesWithEntra;

use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class FindOrCreateByAzureIdTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();
        $this->useDirectoryEmulator();
    }

    public function test(): void
    {
        $this->assertInstanceOf(
            User::class,
            User::findOrCreateByAzureId('abc123'),
        );
    }
}
