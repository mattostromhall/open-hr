<?php

namespace Domain\People\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class PersonQueryBuilder extends Builder
{
    public function holidayTaken()
    {
        $fullDays = $this->model
            ->holidays()
            ->whereApproved()
            ->whereNull('half_day')
            ->get();

        $halfDays = $this->model
            ->holidays()
            ->whereApproved()
            ->whereNotNull('half_day')
            ->count();

//        return $fullDays + ($halfDays / 2);
        return $fullDays;
    }
}
