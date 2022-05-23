<?php

namespace Domain\People\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class PersonQueryBuilder extends Builder
{
    public function remainingHoliday()
    {
        $holidayUsed = $this->model->holidays()->count();
    }
}
