<?php

namespace NetworkRailBusinessSystems\Common\ResourceCollections;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public $collects = UserResource::class;
}
