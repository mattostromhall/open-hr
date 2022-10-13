<?php

namespace Domain\Absences\Collections;

use Domain\Absences\Models\Sickness;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class SicknessCollection extends Collection
{
    public function numberTaken(): int|float
    {
        return $this->map(fn (Sickness $sickness) => $sickness->duration->inWeekDays())
            ->sum();
    }

    public function includeDuration(): self|SupportCollection
    {
        return $this->map(function (Sickness $sickness) {
            return [
                'duration' => $sickness->duration->inWeekDays(),
                ...$sickness->toArray()
            ];
        });
    }
}
