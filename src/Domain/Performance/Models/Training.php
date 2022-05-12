<?php

namespace Domain\Performance\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Domain\People\Models\Person;
use Support\Concerns\Unguarded;

class Training extends Model
{
    use HasFactory;
    use Unguarded;

    public const REQUESTED = 1;
    public const APPROVED = 2;
    public const REJECTED = 3;

    public const TODO = 1;
    public const STARTED = 2;
    public const COMPLETED = 3;

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
