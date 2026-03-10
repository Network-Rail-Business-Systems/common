<?php

namespace NetworkRailBusinessSystems\Common\Tests\Unit\Models\User\ActivityLog;

use NetworkRailBusinessSystems\Common\Tests\Models\User;
use NetworkRailBusinessSystems\Common\Tests\TestCase;

class LabelTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = new User();
        $this->user->name = 'Bob Holnes';
    }

    public function testLabel(): void
    {
        $this->assertEquals(
            'Bob Holnes',
            $this->user->label(),
        );
    }
}
