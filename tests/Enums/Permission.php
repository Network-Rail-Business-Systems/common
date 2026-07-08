<?php

namespace NetworkRailBusinessSystems\Common\Tests\Enums;

use NetworkRailBusinessSystems\Common\Interfaces\PermissionInterface;
use NetworkRailBusinessSystems\Common\Traits\PermissionTrait;

enum Permission: string implements PermissionInterface
{
    use PermissionTrait;

    case AccessAdmin = 'access_admin';

    case Impersonate = 'impersonate';

    case ManageBanner = 'manage_banner';

    case ManageUsers = 'manage_users';
}
