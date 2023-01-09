<?php

namespace Domain\Absences\Actions;

use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;
use Exception;

class RequestHolidayAction
{
    public function __construct(
        protected CreateHolidayAction $createHoliday,
        protected RequestHolidayReviewAction $requestReview
    ) {
        //
    }

    public function execute(HolidayData $data): Holiday
    {
        $holiday = $this->createHoliday->execute($data);

        throw new Exception('this is a test');
        $this->requestReview->execute($holiday, $data);

        return $holiday;
    }
}
