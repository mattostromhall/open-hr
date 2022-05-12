<?php

namespace Support\Concerns;

use Domain\HR\Models\HR;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasHR
{
    public function person(): HasOne
    {
        return $this->hasOne(Person::class);
    }

    public function hr(): HasOne
    {
        return $this->hasOne(HR::class);
    }
}
