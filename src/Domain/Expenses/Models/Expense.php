<?php

namespace Domain\Expenses\Models;

use Domain\Expenses\Enums\ExpenseStatus;
use Domain\Expenses\Events\ExpenseCreated;
use Domain\Expenses\Events\ExpenseDeleted;
use Domain\Expenses\Events\ExpenseUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Domain\Files\Models\Document;
use Domain\People\Models\Person;
use Support\Concerns\Unguarded;

class Expense extends Model
{
    use HasFactory;
    use Unguarded;

    protected $casts = [
        'status' => ExpenseStatus::class,
        'date' => 'date'
    ];

    protected $dispatchesEvents = [
        'created' => ExpenseCreated::class,
        'updated' => ExpenseUpdated::class,
        'deleted' => ExpenseDeleted::class
    ];

    public function type(): HasOne
    {
        return $this->hasOne(ExpenseType::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
