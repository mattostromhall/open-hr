<?php

namespace Domain\Absences\Actions\Contracts;

use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;

interface RequestHolidayActionInterface
{
    public function execute(HolidayData $data): Holiday;
}
