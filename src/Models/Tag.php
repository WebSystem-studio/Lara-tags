<?php

namespace Websystem\Tags\Models;

use Illuminate\Database\Eloquent\Model;
use Websystem\Tags\Scopes\TagUsedScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory, TagUsedScopes;
}
