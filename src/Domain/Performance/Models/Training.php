<?php

namespace Domain\Performance\Models;

use Domain\Performance\Enums\TrainingState;
use Domain\Performance\Enums\TrainingStatus;
use Domain\Performance\QueryBuilders\TrainingQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Domain\People\Models\Person;
use Support\Concerns\Unguarded;
use Support\Enums\Currency;

class Training extends Model
{
    use HasFactory;
    use Unguarded;

    protected $table = 'training';

    protected $casts = [
        'status' => TrainingStatus::class,
        'state' => TrainingState::class,
        'cost_currency' => Currency::class
    ];

    public static function query(): Builder|TrainingQueryBuilder
    {
        return parent::query();
    }

    public function newEloquentBuilder($query): TrainingQueryBuilder
    {
        return new TrainingQueryBuilder($query);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
