<?php

namespace Domain\Absences\Actions\Contracts;

use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;

interface UpdateHolidayActionInterface
{
    public function execute(Holiday $holiday, HolidayData $data): bool;
}
