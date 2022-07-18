<?php

use Illuminate\Database\Eloquent\Model;
use Websystem\Tags\Scopes\TagUsedScopes;

class TagStub extends Model
{
    use TagUsedScopes;

    protected $connection = 'testbench';

    public $table = 'tags';
}
