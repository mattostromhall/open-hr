<?php

namespace Domain\Absences\Models;

use Domain\Absences\Enums\HalfDay;
use Domain\Absences\Enums\HolidayStatus;
use Domain\Absences\QueryBuilders\HolidayQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Domain\People\Models\Person;
use Support\Casts\PeriodCast;
use Support\Concerns\Unguarded;

class Holiday extends Model
{
    use HasFactory;
    use Unguarded;

    protected $casts = [
        'status' => HolidayStatus::class,
        'start_at' => 'datetime',
        'finish_at' => 'datetime',
        'half_day' => HalfDay::class,
        'duration' => PeriodCast::class
    ];

    public function newEloquentBuilder($query): HolidayQueryBuilder
    {
        return new HolidayQueryBuilder($query);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
