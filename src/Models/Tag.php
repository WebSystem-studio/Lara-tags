<?php

namespace Websystem\Tags\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Websystem\Tags\Scopes\TagUsedScopes;

class Tag extends Model
{
    use HasFactory, TagUsedScopes;
}
