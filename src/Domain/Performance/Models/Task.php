<?php

namespace Domain\Performance\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Concerns\Unguarded;

class Task extends Model
{
    use HasFactory;
    use Unguarded;

    protected $casts = [
        'due_at' => 'date',
        'completed_at' => 'date',
    ];

    public function objective(): BelongsTo
    {
        return $this->belongsTo(Objective::class);
    }
}
