<?php

namespace Domain\Performance\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected $appends = ['days_remaining'];

    public function objective(): BelongsTo
    {
        return $this->belongsTo(Objective::class);
    }

    protected function daysRemaining(): Attribute
    {
        return Attribute::make(
            get: function () {
                $difference = now()->diffInDays($this->due_at);

                return now()->isAfter($this->due_at)
                    ? $difference * -1
                    : $difference;
            }
        );
    }
}
