<?php

namespace Domain\People\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Support\Concerns\Unguarded;

class Manager extends Model
{
    use HasFactory;
    use Unguarded;

    public function person(): HasOne
    {
        return $this->hasOne(Person::class);
    }

    public function directReports(): HasMany
    {
        return $this->hasMany(Person::class);
    }
}
