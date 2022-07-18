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
        //
    }
}
