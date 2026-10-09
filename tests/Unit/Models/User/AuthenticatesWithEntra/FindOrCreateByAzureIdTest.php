<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Models\User\AuthenticatesWithEntra;

use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

    public function testHandles(): void
    {
        $this->directoryShouldReturnEmpty();

        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('You were not found in the directory; this is usually because your Entra account is new or incomplete.');

        User::findOrCreateByAzureId('zxczx');
    }
}
