<?php

namespace NetworkRailBusinessSystems\Common\ResourceCollections;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserRoleCollection extends ResourceCollection
{
    public $collects = UserRoleResource::class;
}
