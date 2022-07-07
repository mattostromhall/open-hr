<?php

namespace App\Http\Absences\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Absences\Models\Holiday;

class HolidayViewModel extends ViewModel
{
    public function __construct(protected Holiday $holiday)
    {
        //
    }

    public function holiday(): Holiday
    {
        return $this->holiday;
    }

    public function requester()
    {
        return $this->holiday->person->full_name;
    }
}
