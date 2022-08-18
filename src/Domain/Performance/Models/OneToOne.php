<?php

namespace Domain\Performance\Models;

use Domain\Performance\Enums\OneToOneStatus;
use Domain\Performance\Enums\RecurrenceInterval;
use Domain\Performance\QueryBuilders\OneToOneQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'person_status' => OneToOneStatus::class,
        'manager_status' => OneToOneStatus::class,
        'scheduled_at' => 'datetime',
        'completed_at' => 'datetime',
        'recurring' => 'boolean',
        'recurrence_interval' => RecurrenceInterval::class
    ];

    protected $appends = ['status'];

    public static function query(): Builder|OneToOneQueryBuilder
    {
        return parent::query();
    }

    public function newEloquentBuilder($query): OneToOneQueryBuilder
    {
        return new OneToOneQueryBuilder($query);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'manager_id');
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'requester_id');
    }

    public function requested(): Person
    {
        return $this->person_id === $this->requester_id
            ? $this->manager
            : $this->person;
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($this->person_status === OneToOneStatus::DECLINED || $this->manager_status === OneToOneStatus::DECLINED) {
                    return OneToOneStatus::DECLINED;
                }

                if ($this->person_status === OneToOneStatus::ACCEPTED && $this->manager_status === OneToOneStatus::ACCEPTED) {
                    return OneToOneStatus::ACCEPTED;
                }

                return OneToOneStatus::INVITED;
            },
        );
    }
}
