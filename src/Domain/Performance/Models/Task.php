<?php

namespace Domain\Performance\Models;

use Domain\Performance\Events\TaskCreated;
use Domain\Performance\Events\TaskDeleted;
use Domain\Performance\Events\TaskUpdated;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Support\Concerns\Unguarded;

class Task extends Model
{
    use HasFactory;
    use Unguarded;
    use SoftDeletes;

    protected $casts = [
        'due_at' => 'date',
        'completed_at' => 'date',
    ];

    protected $dispatchesEvents = [
        'created' => TaskCreated::class,
        'updated' => TaskUpdated::class,
        'deleted' => TaskDeleted::class
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
