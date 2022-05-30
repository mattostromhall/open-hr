<?php

namespace Support\ValueObjects;

use Illuminate\Support\Carbon;
use Support\Exceptions\InvalidPeriodDatesException;

class Period
{
    protected Carbon $start;
    protected Carbon $end;

    public function __construct(Carbon $start, Carbon $end)
    {
        if ($end->isAfter($start)) {
            InvalidPeriodDatesException::because('The End date cannot be before the Start date');
        }

        $this->start = $start;
        $this->end = $end;
    }

    public static function between(Carbon $start, Carbon $end): self
    {
        return new self($start, $end);
    }

    public function inHours(): int
    {
        return $this->start->diffInHours($this->end);
    }

    public function inDays(): int
    {
        return $this->start->diffInDays($this->end);
    }

    public function inWeeks(): int
    {
        return $this->start->diffInWeeks($this->end);
    }

    public function inMonths(): int
    {
        return $this->start->diffInMonths($this->end);
    }

    public function years(): int
    {
        return $this->start->diffInYears($this->end);
    }
}
