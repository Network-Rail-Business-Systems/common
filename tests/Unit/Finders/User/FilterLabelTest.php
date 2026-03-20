<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Finders\User;

use NetworkRailBusinessSystems\Common\Finders\UserFinder;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class FilterLabelTest extends TestCase
{
    protected UserFinder $finder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->finder = new UserFinder();
    }

    public function testWhenRoles(): void
    {
        $this->finder->currentSearch = 'blah';

        $this->assertEquals(
            'Users with Roles',
            $this->finder->filterLabel(UserFinder::FILTER_ROLES),
        );
    }

    public function testWhenAll(): void
    {
        $this->assertEquals(
            'All Users',
            $this->finder->filterLabel(UserFinder::FILTER_ALL),
        );
    }
}
