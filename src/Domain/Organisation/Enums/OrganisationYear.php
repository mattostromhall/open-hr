<?php

namespace Domain\Organisation\Enums;

use Illuminate\Support\Carbon;

enum OrganisationYear : string
{
    case ABSENCE = 'absence';
    case FINANCIAL = 'financial';

    public function start(): Carbon
    {
        $year = Carbon::parse('1 ' . config("hr.{$this->value}_year_start"));

        if (! $year->isPast()) {
            return $year->subYear();
        }

        return $year;
    }
}
