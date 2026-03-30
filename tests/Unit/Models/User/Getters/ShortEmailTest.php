<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Models\User\Getters;

use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class ShortEmailTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = new User();
        $this->user->email = 'jojo.johnson@example.com';
    }

    public function test(): void
    {
        $this->assertEquals(
            'jojo.johnson',
            $this->user->short_email,
        );
    }
}
