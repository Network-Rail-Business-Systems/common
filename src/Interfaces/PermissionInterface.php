<?php

namespace NetworkRailBusinessSystems\Common\Interfaces;

/**
 * @property string $value
 * @method static array<PermissionInterface> cases()
 * @method static static from(string $value)
 */
interface PermissionInterface
{
    /** Which Roles this Permission is assigned to */
    public function roles(): array;

    /** A list of all Permission values as an array of strings */
    public static function values(): array;
}
