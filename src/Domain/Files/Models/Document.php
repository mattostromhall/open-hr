<?php

namespace Domain\Files\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Support\Concerns\Unguarded;

class Document extends Model
{
    use HasFactory;
    use Unguarded;

    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }
}
