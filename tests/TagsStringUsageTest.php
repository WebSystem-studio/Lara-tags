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
    public function can_tag_a_lesson()
    {
        $this->lesson->tag(['Laravel', 'PHP', 'Testing']);
        $this->assertCount(3, $this->lesson->tags);
        foreach (['Laravel', 'PHP', 'Testing'] as $tag) {
            $this->assertContains($tag, $this->lesson->tags->pluck('name')->toArray());
        }
    }

    /** @test */
    public function can_untag_a_lesson()
    {
        $this->lesson->tag(['Laravel', 'PHP', 'Testing', 'Livewire']);
        $this->lesson->untag(['Laravel', 'PHP']);
        $this->assertCount(2, $this->lesson->tags);
        foreach (['Testing', 'Livewire'] as $tag) {
            $this->assertContains($tag, $this->lesson->tags->pluck('name')->toArray());
        }
    }

    /** @test */
    public function can_untag_all_lesson_tags()
    {
        $this->lesson->tag(['Laravel', 'PHP', 'Testing', 'Livewire']);
        $this->lesson->untag();
        $this->lesson->load('tags');
        $this->assertCount(0, $this->lesson->tags);
        $this->assertEquals(0, $this->lesson->tags->count());
    }

    /** @test */
    public function can_retag_lesson_tags()
    {
        $this->lesson->tag(['Laravel', 'PHP', 'Testing', 'Livewire']);
        $this->lesson->retag(['Laravel', 'Full stack', 'Fun stuff']);
        $this->lesson->load('tags');
        $this->assertCount(3, $this->lesson->tags);
        foreach (['Laravel', 'Full stack', 'Fun stuff'] as $tag) {
            $this->assertContains($tag, $this->lesson->tags->pluck('name')->toArray());
        }
    }

    /** @test */
    public function non_existing_tags_are_ignored()
    {
        $this->lesson->tag(['Laravel', 'Non existing tag', 'Backend', 'Full stack', 'Fun stuff']);
        $this->assertCount(4, $this->lesson->tags);
        foreach (['Laravel', 'Backend', 'Full stack', 'Fun stuff'] as $tag) {
            $this->assertContains($tag, $this->lesson->tags->pluck('name')->toArray());
        }
    }

    /** @test */
    public function inconsistent_tag_cases_are_normalised()
    {
        $this->lesson->tag(['LaraveL', 'BacKend', 'Full StaCk', 'FUN stUff']);
        $this->assertCount(4, $this->lesson->tags);
        foreach (['Laravel', 'Backend', 'Full stack', 'Fun stuff'] as $tag) {
            $this->assertContains($tag, $this->lesson->tags->pluck('name')->toArray());
        }
    }
}
