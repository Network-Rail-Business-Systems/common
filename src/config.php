<?php

use NetworkRailBusinessSystems\Common\Controllers\AdminController;
use NetworkRailBusinessSystems\Common\Controllers\UserController;
use NetworkRailBusinessSystems\Common\Controllers\UserRoleController;
use NetworkRailBusinessSystems\Common\Policies\UserPolicy;
use Spatie\Permission\Models\Permission as PermissionModel;
use Spatie\Permission\Models\Role as RoleModel;

return [
    /** Which controllers to use */
    'controllers' => [
        'admin' => AdminController::class,
        'role' => UserRoleController::class,
        'user' => UserController::class,
    ],

    /** Which enums to use */
    'enums' => [
        'permissions' => 'Permission::class',
        'roles' => 'Role::class',
    ],

    /** Whether to force HTTPS regardless of hostname */
    'force_https' => env('FORCE_HTTPS', false),

    /** The path to the main landing page */
    'home' => '/home',

    /** Which models to use */
    'models' => [
        'permission' => PermissionModel::class,
        'role' => RoleModel::class,
        'user' => 'User::class',
    ],

    /** Which Permissions to use; replace with your own Permission::AccessAdmin implementations */
    'permissions' => [
        'access_admin' => 'access_admin',
        'impersonate' => 'impersonate',
        'manage_users' => 'manage_users',
    ],

    /** Which policies to use */
    'policies' => [
        'user' => UserPolicy::class,
    ],

    /**
     * Which view templates to use, currently supports:
     * ¬ bulma
     * ¬ govuk
     */
    'template' => 'govuk',
];
