<?php

namespace NetworkRailBusinessSystems\Common\Tests\Models;

use NetworkRailBusinessSystems\Common\Models\User as BaseUser;
use NetworkRailBusinessSystems\Common\Tests\Database\factories\UserFactory;

class User extends BaseUser
{
    protected static function newFactory(): UserFactory
    {
        return new UserFactory();
    }
}
