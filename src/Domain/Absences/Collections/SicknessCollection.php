<?php

namespace Domain\Absences\Collections;

use Domain\Absences\Models\Sickness;
use Illuminate\Database\Eloquent\Collection;

class SicknessCollection extends Collection
{
    public function numberTaken(): int|float
    {
        return $this->map(fn (Sickness $sickness) => $sickness->duration->inWeekDays())
            ->sum();
    }
}
