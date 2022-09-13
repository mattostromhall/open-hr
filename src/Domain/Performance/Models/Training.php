<?php

namespace Domain\Performance\Models;

use Domain\Performance\Enums\TrainingProgress;
use Domain\Performance\Enums\TrainingStatus;
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
        'progress' => TrainingProgress::class,
        'cost_currency' => Currency::class
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
