<?php

namespace Domain\Absences\Actions\Contracts;

use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;

interface DeleteHolidayActionInterface
{
    public function execute(Holiday $holiday): bool;
}
