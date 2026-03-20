<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Finders\User;

use NetworkRailBusinessSystems\Common\Finders\UserFinder;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class ListStatusesTest extends TestCase
{
    protected UserFinder $finder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->finder = new UserFinder();
    }

    public function test(): void
    {
        $this->assertEquals(
            [],
            $this->finder->listStatuses(),
        );
    }
}
