<?php

namespace Domain\Absences\Models;

use Domain\Absences\Collections\SicknessCollection;
use Domain\Absences\QueryBuilders\SicknessQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Domain\People\Models\Person;
use Support\Casts\PeriodCast;
use Support\Concerns\Unguarded;

class Sickness extends Model
{
    use HasFactory;
    use Unguarded;

    protected $casts = [
        'start_at' => 'date',
        'finish_at' => 'date',
        'duration' => PeriodCast::class
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
}
