<?php

namespace Domain\Absences\Actions;

use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;
use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\DataTransferObjects\NotificationData;

class ReviewHolidayAction
{
    public function __construct(
        protected UpdateHolidayAction $updateHoliday,
        protected CreateNotificationAction $createNotification
    ) {
        //
    }

    public function execute(Holiday $holiday, HolidayData $data): bool
    {
        $updated = $this->updateHoliday->execute($holiday, $data);

        if ($updated) {
            $this->createNotification->execute(
                new NotificationData(
                    body: "Your holiday request has been updated to {$data->status->statusDisplay()}",
                    notifiable_id: $data->person->id,
                    notifiable_type: 'person',
                    title: 'Holiday request reviewed',
                    link: route('holiday.show', [
                        'holiday' => $holiday
                    ])
                )
            );
        }

        return $updated;
    }
}
