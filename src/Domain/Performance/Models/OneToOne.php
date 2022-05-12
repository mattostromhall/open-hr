<?php

namespace Domain\Performance\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Domain\People\Models\Person;
use Support\Concerns\Unguarded;

class OneToOne extends Model
{
    use HasFactory;
    use Unguarded;

    protected $casts = [
        'scheduled_at' => 'datetime',
        'completed_at' => 'datetime',
        'recurring' => 'boolean',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class);
    }
}
