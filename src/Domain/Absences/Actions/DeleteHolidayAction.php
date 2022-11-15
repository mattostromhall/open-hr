<?php

namespace Domain\Absences\Actions;

use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;

class DeleteHolidayAction
{
    public function execute(Holiday $holiday): bool
    {
        return $holiday->delete();
    }
}
