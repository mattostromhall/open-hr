<?php

namespace Domain\Performance\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Domain\People\Models\Person;
use Support\Concerns\Unguarded;

class Objective extends Model
{
    use HasFactory;
    use Unguarded;

    protected $casts = [
        'due_at' => 'date',
        'completed_at' => 'date',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
