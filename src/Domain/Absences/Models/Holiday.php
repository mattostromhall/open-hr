<?php

namespace Domain\Absences\Models;

use Domain\Absences\Collections\HolidayCollection;
use Domain\Absences\Enums\HalfDay;
use Domain\Absences\Enums\HolidayStatus;
use Domain\Absences\Events\HolidayCreated;
use Domain\Absences\Events\HolidayDeleted;
use Domain\Absences\Events\HolidayUpdated;
use Domain\Absences\QueryBuilders\HolidayQueryBuilder;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Support\Casts\PeriodCast;
use Support\Concerns\Reporting;
use Support\Concerns\Unguarded;

class Holiday extends Model
{
    use HasFactory;
    use Unguarded;
    use SoftDeletes;
    use Reporting;

    protected $casts = [
        'status' => HolidayStatus::class,
        'start_at' => 'date',
        'finish_at' => 'date',
        'half_day' => HalfDay::class,
        'duration' => PeriodCast::class
    ];

    protected $dispatchesEvents = [
        'created' => HolidayCreated::class,
        'updated' => HolidayUpdated::class,
        'deleted' => HolidayDeleted::class
    ];

    public static function query(): Builder|HolidayQueryBuilder
    {
        return parent::query();
    }

    public function newEloquentBuilder($query): HolidayQueryBuilder
    {
        return new HolidayQueryBuilder($query);
    }

    public function newCollection(array $models = []): HolidayCollection
    {
        return new HolidayCollection($models);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
