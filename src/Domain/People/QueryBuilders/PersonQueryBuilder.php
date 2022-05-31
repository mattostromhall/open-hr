<?php

namespace Domain\People\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PersonQueryBuilder extends Builder
{
    public function fullDayHolidayTaken(): HasMany
    {
        return $this->model
            ->holidays()
            ->forCurrentYear()
            ->whereApproved()
            ->whereNull('half_day');
    }

    public function halfDayHolidayTaken(): HasMany
    {
        return $this->model
            ->holidays()
            ->forCurrentYear()
            ->whereApproved()
            ->whereNotNull('half_day');
    }
}
