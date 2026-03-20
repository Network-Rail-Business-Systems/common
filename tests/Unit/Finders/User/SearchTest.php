<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Finders\User;

use NetworkRailBusinessSystems\Common\Finders\UserFinder;
use NetworkRailBusinessSystems\Common\ResourceCollections\UserCollection;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class SearchTest extends TestCase
{
    protected UserFinder $finder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->useDatabase();

        $this->finder = new UserFinder();
    }

    public function test(): void
    {
        $this->assertInstanceOf(
            UserCollection::class,
            $this->finder->search(),
        );
    }
}
