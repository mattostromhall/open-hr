<?php

namespace Domain\People\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Concerns\Unguarded;

class Address extends Model
{
    use HasFactory;
    use Unguarded;

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
