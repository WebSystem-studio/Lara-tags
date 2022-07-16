<?php

namespace Websystem\Tags;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Websystem\Tags\Models\Tag;
use Websystem\Tags\Scopes\TaggableScope;

trait HasTags
{
    use TaggableScope;

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function tag($tags)
    {
        $this->addTags($this->getWorkableTags($tags));
    }

    public function retag($tags)
    {
        $this->removeAllTags();
        $this->tag($tags);
    }

    public function untag($tags = null)
    {
        if ($tags === null) {
            $this->removeAllTags();

            return;
        }
        $this->removeTags($this->getWorkableTags($tags));
    }

    private function removeAllTags()
    {
        $this->removeTags($this->tags);
    }

    private function removeTags(Collection $tags)
    {
        $this->tags()->detach($tags);
        foreach ($tags->where('count', '>', 0) as $tag) {
            $tag->decrement('count');
        }
    }

    private function addTags($tags)
    {
        $sync = $this->tags()->syncWithoutDetaching($tags->pluck('id')->toArray());
        foreach (Arr::get($sync, 'attached') as $attachedId) {
            $tags->where('id', $attachedId)->first()->increment('count');
        }
    }

    private function getWorkableTags($tags)
    {
        if (is_array($tags)) {
            return $this->getTagModels($tags);
        }

        if ($tags instanceof Model) {
            return $this->getTagModels([$tags->slug]);
        }

        return $this->filterTagsCollection($tags);
    }

    private function filterTagsCollection(Collection $tags)
    {
        return $tags->filter(function ($tag) {
            return $tag instanceof Model;
        });
    }

    private function getTagModels(array $tags)
    {
        return Tag::whereIn('slug', $this->normaliseTagNames($tags))->get();
    }

    private function normaliseTagNames(array $tags)
    {
        return array_map(function ($tag) {
            return Str::slug($tag);
        }, $tags);
    }
}
