<?php

namespace Domain\Absences\Collections;

use Illuminate\Database\Eloquent\Collection;

class SicknessCollection extends Collection
{
    public function numberTaken(): int|float
    {
        return $this->map(fn ($sickness) => $sickness->duration->inWeekDays())
            ->sum();
    }
}
