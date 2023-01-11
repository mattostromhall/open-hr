<?php

namespace Domain\Absences\Actions;

use Domain\Absences\Actions\Contracts\DeleteHolidayActionInterface;
use Domain\Absences\Models\Holiday;

class DeleteHolidayAction implements DeleteHolidayActionInterface
{
    public function execute(Holiday $holiday): bool
    {
        return $holiday->delete();
    }
}
