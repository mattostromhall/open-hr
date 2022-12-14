<?php

namespace Support\Models;

use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Support\Concerns\Unguarded;

class Report extends Model
{
    use HasFactory;
    use Unguarded;
    use SoftDeletes;

    protected $casts = [
        'condition_sets' => 'array'
    ];
}
