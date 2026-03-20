<?php

namespace NetworkRailBusinessSystems\Common\Interfaces;

use BackedEnum;

interface PermissionInterface extends BackedEnum
{
    /** Which Roles this Permission is assigned to */
    public function roles(): array;

    /** A list of all Permission values as an array of strings */
    public static function values(): array;
}
