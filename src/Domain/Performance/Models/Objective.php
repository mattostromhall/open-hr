<?php

namespace Domain\Performance\Models;

use Domain\Performance\Events\ObjectiveCreated;
use Domain\Performance\Events\ObjectiveDeleted;
use Domain\Performance\Events\ObjectiveUpdated;
use Domain\Performance\QueryBuilders\ObjectiveQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\SoftDeletes;
use Support\Casts\HTML;
use Support\Concerns\Reporting;
use Support\Concerns\Unguarded;

class Objective extends Model
{
    use HasFactory;
    use Unguarded;
    use SoftDeletes;
    use Reporting;

    protected $casts = [
        'description' => HTML::class,
        'due_at' => 'date',
        'completed_at' => 'date',
    ];

    protected $dispatchesEvents = [
        'created' => ObjectiveCreated::class,
        'updated' => ObjectiveUpdated::class,
        'deleted' => ObjectiveDeleted::class
    ];

    protected $appends = ['days_remaining'];

    public static function query(): Builder|ObjectiveQueryBuilder
    {
        return parent::query();
    }

    public function newEloquentBuilder($query): ObjectiveQueryBuilder
    {
        return new ObjectiveQueryBuilder($query);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
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
