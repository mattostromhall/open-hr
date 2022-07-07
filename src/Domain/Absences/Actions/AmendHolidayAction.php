<?php

namespace Domain\Absences\Actions;

use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;

class AmendHolidayAction
{
    public function __construct(
        protected UpdateHolidayAction $updateHoliday,
        protected RequestHolidayReviewAction $requestReview
    ) {
        //
    }

    public function execute(Holiday $holiday, HolidayData $data): bool
    {
        $updated = $this->updateHoliday->execute($holiday, $data);

        if ($updated) {
            $this->requestReview->execute($holiday, $data);
        }

        return $updated;
    }
}
