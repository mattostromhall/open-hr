<?php

namespace Domain\Absences\Actions;

use Domain\Absences\Actions\Contracts\CreateHolidayActionInterface;
use Domain\Absences\Actions\Contracts\RequestHolidayActionInterface;
use Domain\Absences\Actions\Contracts\RequestHolidayReviewActionInterface;
use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;

class RequestHolidayAction implements RequestHolidayActionInterface
{
    public function __construct(
        protected CreateHolidayActionInterface $createHoliday,
        protected RequestHolidayReviewActionInterface $requestReview
    ) {
        //
    }

    public function execute(HolidayData $data): Holiday
    {
        $holiday = $this->createHoliday->execute($data);

        $this->requestReview->execute($holiday, $data);

        return $holiday;
    }
}
