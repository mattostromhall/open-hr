<?php

namespace Domain\Expenses\Models;

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
        'date' => 'date',
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
