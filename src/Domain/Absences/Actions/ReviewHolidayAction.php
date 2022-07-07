<?php

namespace Domain\Absences\Actions;

use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;

class ReviewHolidayAction
{
    public function __construct(protected UpdateHolidayAction $updateHoliday)
    {
        //
    }

    public function execute(Holiday $holiday, HolidayData $data): bool
    {
        $updated = $this->updateHoliday->execute($holiday, $data);

        if ($updated) {
            // notify person of review here
        }

        return $updated;
    }
}
