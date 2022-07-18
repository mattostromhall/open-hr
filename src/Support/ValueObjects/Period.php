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

    protected function calculatedFinish(): Carbon
    {
        return $this->start->isStartOfDay() && $this->finish->isStartOfDay()
            ? $this->finish->copy()->addDay()
            : $this->finish;
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
        return $this->start->diffInHours($this->calculatedFinish());
    }

    public function inDays(): int
    {
        return $this->start->diffInDays($this->calculatedFinish());
    }

    public function inWeekDays(): int
    {
        return $this->start->diffInDaysFiltered(function (Carbon $date) {
            return ! $date->isWeekend();
        }, $this->calculatedFinish());
    }

    public function inWeeks(): int
    {
        return $this->start->diffInWeeks($this->calculatedFinish());
    }

    public function inMonths(): int
    {
        return $this->start->diffInMonths($this->calculatedFinish());
    }

    public function inYears(): int
    {
        return $this->start->diffInYears($this->calculatedFinish());
    }
}
