<?php

namespace Domain\Expenses\Models;

use Domain\Expenses\Events\ExpenseTypeCreated;
use Domain\Expenses\Events\ExpenseTypeDeleted;
use Domain\Expenses\Events\ExpenseTypeUpdated;
use Domain\Expenses\QueryBuilders\ExpenseTypeQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Support\Concerns\Reporting;
use Support\Concerns\Unguarded;

class ExpenseType extends Model
{
    use HasFactory;
    use Unguarded;
    use SoftDeletes;
    use Reporting;

    protected $dispatchesEvents = [
        'created' => ExpenseTypeCreated::class,
        'updated' => ExpenseTypeUpdated::class,
        'deleted' => ExpenseTypeDeleted::class
    ];

    public static function query(): Builder|ExpenseTypeQueryBuilder
    {
        return parent::query();
    }

    public function newEloquentBuilder($query): ExpenseTypeQueryBuilder
    {
        return new ExpenseTypeQueryBuilder($query);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
}
