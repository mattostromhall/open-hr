<?php

namespace Domain\Expenses\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Concerns\Unguarded;

class ExpenseType extends Model
{
    use HasFactory;
    use Unguarded;

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
}
