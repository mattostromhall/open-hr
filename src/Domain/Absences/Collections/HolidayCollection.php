<?php

namespace Domain\Absences\Collections;

use Domain\Absences\Models\Holiday;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class HolidayCollection extends Collection
{
    public function numberTaken(): int|float
    {
        return $this->map(function (Holiday $holiday) {
            if ($holiday->half_day) {
                return 0.5;
            }

            return $holiday->duration->inWeekDays();
        })->sum();
    }

    public function includeDuration(): self|SupportCollection
    {
        return $this->map(function (Holiday $holiday) {
            return [
            'duration' => $holiday->duration->inWeekDays(),
            ...$holiday->toArray()
        ];
        });
    }
}
