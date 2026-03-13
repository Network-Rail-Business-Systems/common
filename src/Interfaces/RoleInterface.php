<?php

namespace NetworkRailBusinessSystems\Common\Interfaces;

use BackedEnum;

/**
 * @property string $value
 * @method static array<RoleInterface> cases()
 * @method static static from(string $value)
 */
interface RoleInterface extends BackedEnum
{
    /** Whether this Role can grant the given Role */
    public function canGrant(RoleInterface $role): bool;

    /** Which Roles each Role conflicts with; use a match statement */
    public function conflicts(): array;

    /** Whether this Role conflicts with the given Role */
    public function conflictsWith(RoleInterface $role): bool;

    /** Which Roles each Role can assign; use a match statement */
    public function grants(): array;

    /** The Permissions each Role has been assigned; use a match statement */
    public function permissions(): array;

    /** A list of all Role values as an array of strings */
    public static function values(): array;
}
