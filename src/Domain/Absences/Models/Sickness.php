<?php

namespace Domain\Absences\Models;

use Domain\Absences\Collections\SicknessCollection;
use Domain\Absences\Events\SicknessCreated;
use Domain\Absences\Events\SicknessDeleted;
use Domain\Absences\Events\SicknessUpdated;
use Domain\Absences\QueryBuilders\SicknessQueryBuilder;
use Domain\Files\Models\Document;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Support\Casts\PeriodCast;
use Support\Concerns\Reporting;
use Support\Concerns\Unguarded;

class Sickness extends Model
{
    use HasFactory;
    use Unguarded;
    use SoftDeletes;
    use Reporting;

    protected $casts = [
        'start_at' => 'date',
        'finish_at' => 'date',
        'duration' => PeriodCast::class
    ];

    protected $dispatchesEvents = [
        'created' => SicknessCreated::class,
        'updated' => SicknessUpdated::class,
        'deleted' => SicknessDeleted::class
    ];

    public function newEloquentBuilder($query): SicknessQueryBuilder
    {
        return new SicknessQueryBuilder($query);
    }

    public function newCollection(array $models = []): SicknessCollection
    {
        return new SicknessCollection($models);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
