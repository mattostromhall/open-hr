<?php

namespace Domain\Performance\Models;

use Domain\Performance\Enums\TrainingState;
use Domain\Performance\Enums\TrainingStatus;
use Domain\Performance\Events\TrainingCreated;
use Domain\Performance\Events\TrainingDeleted;
use Domain\Performance\Events\TrainingUpdated;
use Domain\Performance\QueryBuilders\TrainingQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\SoftDeletes;
use Support\Concerns\Unguarded;
use Support\Enums\Currency;

class Training extends Model
{
    use HasFactory;
    use Unguarded;
    use SoftDeletes;

    protected $table = 'training';

    protected $casts = [
        'status' => TrainingStatus::class,
        'state' => TrainingState::class,
        'cost_currency' => Currency::class
    ];

    protected $dispatchesEvents = [
        'created' => TrainingCreated::class,
        'updated' => TrainingUpdated::class,
        'deleted' => TrainingDeleted::class
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
