<?php

namespace Domain\Expenses\Models;

use Domain\Expenses\Events\ExpenseTypeCreated;
use Domain\Expenses\Events\ExpenseTypeDeleted;
use Domain\Expenses\Events\ExpenseTypeUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Concerns\Unguarded;

class ExpenseType extends Model
{
    use HasFactory;
    use Unguarded;

    protected $dispatchesEvents = [
        'created' => ExpenseTypeCreated::class,
        'updated' => ExpenseTypeUpdated::class,
        'deleted' => ExpenseTypeDeleted::class
    ];

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
}
