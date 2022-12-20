<?php

namespace Domain\Expenses\Models;

use Domain\Expenses\Enums\ExpenseStatus;
use Domain\Expenses\Events\ExpenseCreated;
use Domain\Expenses\Events\ExpenseDeleted;
use Domain\Expenses\Events\ExpenseUpdated;
use Domain\Expenses\QueryBuilders\ExpenseQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Domain\Files\Models\Document;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\SoftDeletes;
use Support\Casts\Money;
use Support\Concerns\Reporting;
use Support\Concerns\Unguarded;
use Support\Enums\Currency;

class Expense extends Model
{
    use HasFactory;
    use Unguarded;
    use SoftDeletes;
    use Reporting;

    protected $casts = [
        'status' => ExpenseStatus::class,
        'value' => Money::class,
        'value_currency' => Currency::class,
        'date' => 'date'
    ];

    protected $dispatchesEvents = [
        'created' => ExpenseCreated::class,
        'updated' => ExpenseUpdated::class,
        'deleted' => ExpenseDeleted::class
    ];

    public static function query(): Builder|ExpenseQueryBuilder
    {
        return parent::query();
    }

    public function newEloquentBuilder($query): ExpenseQueryBuilder
    {
        return new ExpenseQueryBuilder($query);
    }

    public function type(): HasOne
    {
        return $this->hasOne(ExpenseType::class, 'id', 'expense_type_id');
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
