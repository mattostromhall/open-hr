<?php

namespace Domain\Absences\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Domain\People\Models\Person;
use Support\Concerns\Unguarded;

class Holiday extends Model
{
    use HasFactory;
    use Unguarded;

    public const PENDING = 1;
    public const APPROVED = 2;
    public const REJECTED = 3;

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'half_day' => 'boolean',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
