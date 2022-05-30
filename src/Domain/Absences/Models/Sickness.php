<?php

namespace Domain\Absences\Models;

use Domain\Absences\QueryBuilders\SicknessQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Domain\People\Models\Person;
use Support\Concerns\Unguarded;

class Sickness extends Model
{
    use HasFactory;
    use Unguarded;

    protected $casts = [
        'start_at' => 'datetime',
        'finish_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): SicknessQueryBuilder
    {
        return new SicknessQueryBuilder($query);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
