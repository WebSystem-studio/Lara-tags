<?php

namespace Websystem\Tags\Scopes;

trait TaggableScope
{
    public function scopeWithAnyTag($query, array $tags)
    {
        return $query->hasTags($tags);
    }

    public function scopeWithAllTags($query, array $tags)
    {
        foreach ($tags as $tag) {
            $query->hasTags([$tag]);
        }

        return $query;
    }

    public function scopeHasTags($query, array $tags)
    {
        return $query->whereHas('tags', function ($q) use ($tags) {
            return   $q->whereIn('slug', $tags);
        });
    }
}
