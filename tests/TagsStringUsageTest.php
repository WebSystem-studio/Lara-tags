<?php

use Illuminate\Support\Str;

class TagsStringUsageTest extends TestCase
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
    public function can_tag_lesson()
    {
        $this->lesson->tag(['Laravel', 'PHP', 'Testing']);
        $this->assertCount(3, $this->lesson->tags);
        foreach (['Laravel', 'PHP', 'Testing'] as $tag) {
            $this->assertContains($tag, $this->lesson->tags->pluck('name')->toArray());
        }
    }
}
