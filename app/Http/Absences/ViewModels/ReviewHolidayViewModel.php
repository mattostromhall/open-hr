<?php

namespace App\Http\Absences\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Absences\Models\Holiday;

class ReviewHolidayViewModel extends ViewModel
{
    public function __construct(protected Holiday $holiday)
    {
        //
    }

    public function requester(): string
    {
        return $this->holiday
            ->person
            ->fullName;
    }

    public function holiday(): Holiday
    {
        return $this->holiday;
    }

    public function status(): string
    {
        return $this->holiday->status->statusDisplay();
    }

    public function duration(): int
    {
        return $this->holiday->duration->inWeekDays();
    }
}
