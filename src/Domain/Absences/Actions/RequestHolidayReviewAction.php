<?php

namespace Domain\Absences\Actions;

use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;

class RequestHolidayReviewAction
{
    public function execute(Holiday $holiday, HolidayData $data): void
    {
        $manager = $data->person->manager;

        $manager->notifications()->create([
            'body' => "Holiday requested by {$data->person->fullName}, click here to review.",
            'link' => route('holiday.review', [
                'holiday' => $holiday
            ])
        ]);
    }
}
