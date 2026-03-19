<?php

namespace NetworkRailBusinessSystems\Common\Interfaces;

use BackedEnum;

interface RoleInterface extends BackedEnum
{
    /** Whether this Role can grant the given Role */
    public function canGrant(RoleInterface $role): bool;

    /** Whether this Role can impersonate a given Role */
    public function canImpersonate(RoleInterface $role): bool;

    /** Which Roles each Role conflicts with; use a match statement */
    public function conflicts(): array;

    /** Whether this Role conflicts with the given Role */
    public function conflictsWith(RoleInterface $role): bool;

    /** Which Roles each Role can assign; use a match statement */
    public function grants(): array;

    /** Which Roles this Role can impersonate */
    public function allowedImpersonations(): array;

    /** The Permissions each Role has been assigned; use a match statement */
    public function permissions(): array;

    /** A list of all Role values as an array of strings */
    public static function values(): array;
}
