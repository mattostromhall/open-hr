<?php

namespace Domain\Absences\Actions;

use Domain\Absences\Actions\Contracts\ReviewHolidayActionInterface;
use Domain\Absences\Actions\Contracts\UpdateHolidayActionInterface;
use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;
use Domain\Notifications\Actions\Contracts\CreateNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;

class ReviewHolidayAction implements ReviewHolidayActionInterface
{
    public function __construct(
        protected UpdateHolidayActionInterface $updateHoliday,
        protected CreateNotificationActionInterface $createNotification
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
                    notifiable_type: NotifiableType::PERSON,
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
