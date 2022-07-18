<?php

use Illuminate\Support\Str;

class TagsModelUsageTest extends TestCase
{
    protected $lesson;

    public function setUp(): void
    {
        parent::setUp();
        foreach (['Laravel', 'PHP', 'Testing', 'Livewire', 'Nova', 'Cashier', 'Frontend', 'Backend', 'Full stack', 'Fun stuff'] as $tag) {
            \TagStub::create([
                'name' => $tag,
                'slug' => Str::slug($tag),
                'count' => 0,
            ]);
        }
        $this->lesson = \LessonStub::create([
            'title' => 'Lesson 1',
        ]);
    }

    /** @test */
    public function can_tag_a_lesson()
    {
        $this->lesson->tag(\TagStub::where('slug', 'laravel')->first());
        $this->assertCount(1, $this->lesson->tags);
        $this->assertContains('Laravel', $this->lesson->tags->pluck('name')->toArray());
    }

    /** @test */
    public function can_tag_lesson_with_collection_of_tags()
    {
        $tags = \TagStub::whereIn('slug', ['laravel', 'php', 'livewire'])->get();
        $this->lesson->tag($tags);
        $this->assertCount(3, $this->lesson->tags);
        foreach (['Laravel', 'PHP', 'Livewire'] as $tag) {
            $this->assertContains($tag, $this->lesson->tags->pluck('name')->toArray());
        }
    }

    /** @test */
    public function can_untag_lesson_tags()
    {
        $tags = \TagStub::whereIn('slug', ['laravel', 'php', 'livewire'])->get();
        $this->lesson->tag($tags);
        $this->lesson->untag($tags->first());
        $this->assertCount(2, $this->lesson->tags);
        foreach (['PHP', 'Livewire'] as $tag) {
            $this->assertContains($tag, $this->lesson->tags->pluck('name'));
        }
    }

    /** @test */
    public function can_untag_all_lesson_tags()
    {
        $tags = \TagStub::whereIn('slug', ['laravel', 'php', 'livewire'])->get();
        $this->lesson->tag($tags);
        $this->lesson->untag();
        $this->lesson->load('tags');
        $this->assertCount(0, $this->lesson->tags);
    }

    /** @test */
    public function can_retag_lesson_tags()
    {
        $tags = \TagStub::whereIn('slug', ['laravel', 'php', 'livewire'])->get();
        $toRetags = \TagStub::whereIn('slug', ['full-stack', 'fun-stuff'])->get();
        $this->lesson->tag($tags);
        $this->lesson->retag($toRetags);
        $this->lesson->load('tags');
        $this->assertCount(2, $this->lesson->tags);
        foreach (['Full stack', 'Fun stuff'] as $tag) {
            $this->assertContains($tag, $this->lesson->tags->pluck('name'));
        }
    }

    /** @test */
    public function non_models_are_filtered_when_using_collection()
    {
        $tags = \TagStub::whereIn('slug', ['laravel', 'php', 'livewire'])->get();
        $tags->push('not a tag model');
        $this->lesson->tag($tags);
        $this->assertCount(3, $this->lesson->tags);
    }
}
