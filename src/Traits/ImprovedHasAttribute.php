<?php

namespace NetworkRailBusinessSystems\Common\Traits;

/** Adds $fillable and $guarded to a Model's `hasAttribute()` check */
trait ImprovedHasAttribute
{
    public function hasAttribute($key): bool
    {
        if (! $key) {
            return false;
        }

        if (
            in_array($key, $this->fillable) === true
            || in_array($key, $this->guarded) === true
        ) {
            return true;
        }

        return parent::hasAttribute($key);
    }
}
