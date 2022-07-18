<?php

use Illuminate\Support\Str;

class TagsCountTest extends TestCase
{
    protected $lesson;

    public function setUp(): void
    {
        parent::setUp();

        $this->lesson = \LessonStub::create([
            'title' => 'Lesson 1',
        ]);
    }

    /** @test */
    public function tag_count_is_incremented_when_tagged()
    {
        $tag = \TagStub::create([
            'name' => 'Laravel',
            'slug' => Str::slug('Laravel'),
            'count' => 0,
        ]);

        $this->lesson->tag(['Laravel']);
        $tag = $tag->fresh();
        $this->assertEquals(1, $tag->count);
    }

    /** @test */
    public function tag_count_is_decremented_when_tagged()
    {
        $tag = \TagStub::create([
            'name' => 'Laravel',
            'slug' => Str::slug('Laravel'),
            'count' => 7000,
        ]);

        $this->lesson->tag(['Laravel']);
        $this->lesson->untag(['Laravel']);
        $tag = $tag->fresh();
        $this->assertEquals(7000, $tag->count);
    }

    /** @test */
    public function tag_count_does_not_dip_below_zero()
    {
        $tag = \TagStub::create([
            'name' => 'Laravel',
            'slug' => Str::slug('Laravel'),
            'count' => 0,
        ]);
        $this->lesson->untag(['Laravel']);
        $tag = $tag->fresh();
        $this->assertEquals(0, $tag->count);
    }

    /** @test */
    public function tag_coun_does_not_incremented_if_alredy_exists()
    {
        $tag = \TagStub::create([
            'name' => 'Laravel',
            'slug' => Str::slug('Laravel'),
            'count' => 0,
        ]);
        $this->lesson->tag(['Laravel']);
        $this->lesson->retag(['Laravel']);
        $this->lesson->tag(['Laravel']);
        $this->lesson->tag(['Laravel']);
        $tag = $tag->fresh();
        $this->assertEquals(1, $tag->count);
    }
}
