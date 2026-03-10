<?php

use NetworkRailBusinessSystems\Common\Controllers\User\UserController;
use NetworkRailBusinessSystems\Common\Controllers\User\UserRoleController;
use NetworkRailBusinessSystems\Common\Policies\UserPolicy;
use Spatie\Permission\Models\Permission as PermissionModel;
use Spatie\Permission\Models\Role as RoleModel;

return [
    /** The path to the main landing page */
    'home' => '/home',

    /** Whether to force HTTPS regardless of hostname */
    'force_https' => env('FORCE_HTTPS', false),

    /**
     * Which view templates to use, currently supports:
     * ¬ bulma
     * ¬ govuk
     */
    'template' => 'govuk',

    'controllers' => [
        'role' => UserRoleController::class,
        'user' => UserController::class,
    ],

    /** Which enums to use */
    'enums' => [
        'permissions' => 'Permission::class',
        'roles' => 'Role::class',
    ],

    /** Which models to use */
    'models' => [
        'permission' => PermissionModel::class,
        'role' => RoleModel::class,
        'user' => 'User::class',
    ],

    /** Which policies to use */
    'policies' => [
        'user' => UserPolicy::class,
    ],
];
