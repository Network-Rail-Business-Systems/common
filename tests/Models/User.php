<?php

namespace NetworkRailBusinessSystems\Common\Tests\Models;

use NetworkRailBusinessSystems\Common\Interfaces\PermissionInterface;
use NetworkRailBusinessSystems\Common\Models\User as BaseUser;
use NetworkRailBusinessSystems\Common\Tests\Database\factories\UserFactory;
use NetworkRailBusinessSystems\Common\Tests\Enums\Permission;

class User extends BaseUser
{
    protected static function newFactory(): UserFactory
    {
        return new UserFactory();
    }

    public static function impersonatePermission(): PermissionInterface
    {
        return Permission::Impersonate;
    }

    public static function managePermission(): PermissionInterface
    {
        return Permission::ManageUsers;
    }
}
