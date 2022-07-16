<?php

namespace Websystem\Tags\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Websystem\Tagg\Models\TagUsedScopes;

class Tag extends Model
{
    use HasFactory, TagUsedScopes;
}
