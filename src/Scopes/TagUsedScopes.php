<?php

namespace Websystem\Tags\Scopes;

trait TagUsedScopes
{
    public function scopeUsedGte($query, $count)
    {
        return $query->where('used', '>=', $count);
    }

    public function scopeUsedGt($query, $count)
    {
        return $query->where('used', '>', $count);
    }

    public function scopeUsedLte($query, $count)
    {
        return $query->where('used', '<=', $count);
    }

    public function scopeUsedLt($query, $count)
    {
        return $query->where('used', '<', $count);
    }
}
