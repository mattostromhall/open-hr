<?php

namespace Domain\Absences\Collections;

use Illuminate\Database\Eloquent\Collection;

class HolidayCollection extends Collection
{
    public function numberTaken(): int|float
    {
        return $this->map(function ($holiday) {
            if ($holiday->half_day) {
                return 0.5;
            }

            return $holiday->duration->inWeekDays();
        })->sum();
    }
}
