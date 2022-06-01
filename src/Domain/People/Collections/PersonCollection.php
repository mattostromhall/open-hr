<?php

namespace Domain\People\Collections;

use Illuminate\Database\Eloquent\Collection;

class PersonCollection extends Collection
{
    public function holidayRemaining(): int|float
    {
        $allocated = $this->base_holiday_allocation + $this->holiday_carried;

        $fullDays = $this->fullDayHolidayTaken()
            ->get()
            ->map(fn ($holiday) => $holiday->duration->inDays())
            ->sum();

        $halfDays = $this->halfDayHolidayTaken()->count();

        $taken = $fullDays + ($halfDays ? $halfDays / 2 : 0);

        return $allocated - $taken;
    }
}
