<?php

use Illuminate\Database\Eloquent\Model;
use Websystem\Tags\HasTags;

class LessonStub extends Model
{
    use  HasTags;

    protected $connection = 'testbench';

    public $table = 'lessons';
}
