<?php

namespace Domain\People\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PersonQueryBuilder extends Builder
{
    public function holidayThisYear(): HasMany
    {
        return $this->model
            ->holidays()
            ->forCurrentYear()
            ->whereApproved();
    }

    public function sicknessThisYear(): HasMany
    {
        return $this->model
            ->sicknesses()
            ->forCurrentYear();
    }
}
