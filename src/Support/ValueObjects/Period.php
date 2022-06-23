<?php

namespace Support\ValueObjects;

use Illuminate\Support\Carbon;
use Support\Exceptions\InvalidPeriodDatesException;

class Period
{
    protected Carbon $start;
    protected Carbon $finish;

    public function __construct(Carbon $start, Carbon $finish)
    {
        if ($finish->isAfter($start)) {
            InvalidPeriodDatesException::because('The Finish date cannot be before the Start date');
        }

        $this->start = $start;
        $this->finish = $finish;
    }

    public static function from(Carbon $start, Carbon $finish): self
    {
        return new self($start, $finish);
    }

    public static function fromDateStrings(string $start, string $finish): self
    {
        return new self(Carbon::parse($start), Carbon::parse($finish));
    }

    public function start(): Carbon
    {
        return $this->start;
    }

    public function finish(): Carbon
    {
        return $this->finish;
    }

    public function inHours(): int
    {
        return $this->start->diffInHours($this->finish);
    }

    public function inDays(): int
    {
        return $this->start->diffInDays($this->finish);
    }

    public function inWeekDays(): int
    {
        return $this->start->diffInDaysFiltered(function (Carbon $date) {
            return ! $date->isWeekend();
        }, $this->finish);
    }

    public function inWeeks(): int
    {
        return $this->start->diffInWeeks($this->finish);
    }

    public function inMonths(): int
    {
        return $this->start->diffInMonths($this->finish);
    }

    public function inYears(): int
    {
        return $this->start->diffInYears($this->finish);
    }
}
