<?php

namespace Support\Models;

use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Support\Concerns\Unguarded;

class ActionLog extends Model
{
    use HasFactory;
    use Unguarded;

    protected $casts = [
        'payload' => 'array'
    ];

    public function actionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
