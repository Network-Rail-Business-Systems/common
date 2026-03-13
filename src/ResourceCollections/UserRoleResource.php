<?php

namespace NetworkRailBusinessSystems\Common\ResourceCollections;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use NetworkRailBusinessSystems\Common\Models\User;
use Spatie\Permission\Models\Role;

/** @mixin Role */
class UserRoleResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var User $user */
        $user = $request->user;

        /** @var User $viewer */
        $viewer = Auth::user();

        /** @var Role $role */
        $role = $this->resource;

        $hasRole = $user->hasRole($role) === true;
        $action = $hasRole === true
            ? 'remove'
            : 'assign';

        return [
            'name' => $role->name,
            'status' => $hasRole === true ? 'Active' : 'Inactive',
            'colour' => $hasRole === true ? 'blue' : 'grey',
            'action' => $hasRole === true ? 'Remove' : 'Assign',
            'link' => route("common.users.roles.$action", [$user, $role]),
            'hide' => $viewer->can($action, [$user, $role]) === false
                ? 1
                : 0,
        ];
    }
}
