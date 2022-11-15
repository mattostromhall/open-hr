<?php

namespace Domain\Absences\Actions;

use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;
use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\Actions\SendEmailNotificationAction;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;

class CancelHolidayAction
{
    public function __construct(
        protected DeleteHolidayAction $deleteHoliday,
        protected CreateNotificationAction $createNotification,
        protected SendEmailNotificationAction $sendEmail
    ) {
        //
    }

    public function execute(Holiday $holiday, HolidayData $data): bool
    {
        $deleted = $this->deleteHoliday->execute($holiday);
        $manager = $data->person->manager;

        if ($deleted && $manager) {
            $this->createNotification->execute(
                new NotificationData(
                    body: "Holiday Request for {$data->person->full_name}, starting at {$data->start_at->toDateString()} has been cancelled.",
                    notifiable_id: $manager->id,
                    notifiable_type: 'person',
                    title: 'Holiday Request Cancelled'
                )
            );

            $this->sendEmail->execute(
                new EmailNotificationData(
                    recipients: [$manager->user->email],
                    subject: 'Holiday Request Cancelled',
                    body: "Holiday Request for {$data->person->full_name}, starting at {$data->start_at->toDateString()} has been cancelled."
                )
            );
        }

        return $deleted;
    }
}
