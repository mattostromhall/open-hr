<?php

namespace Domain\Absences\Actions;

use Domain\Absences\Actions\Contracts\RequestHolidayReviewActionInterface;
use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;
use Domain\Notifications\Actions\Contracts\CreateNotificationActionInterface;
use Domain\Notifications\Actions\Contracts\SendEmailNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;

class RequestHolidayReviewAction implements RequestHolidayReviewActionInterface
{
    public function __construct(
        protected CreateNotificationActionInterface $createNotification,
        protected SendEmailNotificationActionInterface $sendEmail
    ) {
        //
    }

    public function execute(Holiday $holiday, HolidayData $data): void
    {
        $manager = $data->person->manager;

        if (! $manager) {
            return;
        }

        $this->createNotification->execute(
            new NotificationData(
                body: "Holiday requested by {$data->person->fullName}, click here to review.",
                notifiable_id: $manager->id,
                notifiable_type: NotifiableType::PERSON,
                title: 'New holiday request',
                link: route('holiday.review.show', [
                    'holiday' => $holiday
                ])
            )
        );

        $this->sendEmail->execute(
            new EmailNotificationData(
                recipients: [$manager->user->email],
                subject: 'New holiday request',
                body: "Holiday requested by {$data->person->fullName}, click here to review.",
                link: route('holiday.review.show', [
                    'holiday' => $holiday
                ])
            )
        );
    }
}
