<?php

namespace NetworkRailBusinessSystems\Common\ResourceCollections;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use NetworkRailBusinessSystems\Common\Interfaces\RoleInterface;
use NetworkRailBusinessSystems\Common\Models\User;

class UserRoleResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var User $user */
        $user = $request->user;

        /** @var User $viewer */
        $viewer = Auth::user();

        /** @var class-string<RoleInterface> $roleClass */
        $roleClass = config('common.enums.roles');
        $role = $roleClass::from($this->resource->name);

        $hasRole = $user->hasRole($role) === true;
        $action = $hasRole === true
            ? 'remove'
            : 'assign';

        return [
            'name' => $role->value,
            'status' => $hasRole === true ? 'Active' : 'Inactive',
            'colour' => $hasRole === true ? 'blue' : 'grey',
            'action' => $hasRole === true ? 'Remove' : 'Assign',
            'link' => route("admin.users.roles.$action", [$user, $role]),
            'hide' => $viewer->can("{$action}Role", [$user, $role]) === false
                ? 1
                : 0,
        ];
    }
}
