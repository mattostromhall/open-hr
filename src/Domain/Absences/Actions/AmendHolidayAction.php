<?php

namespace Domain\Absences\Actions;

use Domain\Absences\Actions\Contracts\AmendHolidayActionInterface;
use Domain\Absences\Actions\Contracts\RequestHolidayReviewActionInterface;
use Domain\Absences\Actions\Contracts\UpdateHolidayActionInterface;
use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;

class AmendHolidayAction implements AmendHolidayActionInterface
{
    public function __construct(
        protected UpdateHolidayActionInterface $updateHoliday,
        protected RequestHolidayReviewActionInterface $requestReview
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
