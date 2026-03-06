<?php

namespace NetworkRailBusinessSystems\Common\ResourceCollections;

use Illuminate\Http\Resources\Json\JsonResource;
use NetworkRailBusinessSystems\Common\Models\User;

/** @mixin User */
class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'roles' => $this->roles->implode('name', ', '),
            'link' => route('admin.users.show', $this),
        ];
    }
}
