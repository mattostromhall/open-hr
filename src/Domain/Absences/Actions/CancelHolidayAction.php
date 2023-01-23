<?php

namespace Domain\Absences\Actions;

use Domain\Absences\Actions\Contracts\CancelHolidayActionInterface;
use Domain\Absences\Actions\Contracts\DeleteHolidayActionInterface;
use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;
use Domain\Notifications\Actions\Contracts\CreateNotificationActionInterface;
use Domain\Notifications\Actions\Contracts\SendEmailNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;

class CancelHolidayAction implements CancelHolidayActionInterface
{
    public function __construct(
        protected DeleteHolidayActionInterface $deleteHoliday,
        protected CreateNotificationActionInterface $createNotification,
        protected SendEmailNotificationActionInterface $sendEmail
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
                    notifiable_type: NotifiableType::PERSON,
                    title: 'Holiday Request Cancelled'
                )
            );

            $this->sendEmail->execute(
                new EmailNotificationData(
                    recipients: [$manager->email],
                    subject: 'Holiday Request Cancelled',
                    body: "Holiday Request for {$data->person->full_name}, starting at {$data->start_at->toDateString()} has been cancelled."
                )
            );
        }

        return $deleted;
    }
}
