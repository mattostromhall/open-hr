<?php

namespace Domain\Absences\Actions;

use Domain\Absences\Actions\Contracts\CancelSicknessActionInterface;
use Domain\Absences\Actions\Contracts\DeleteSicknessActionInterface;
use Domain\Absences\DataTransferObjects\SicknessData;
use Domain\Absences\Models\Sickness;
use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\Actions\SendEmailNotificationAction;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;

class CancelSicknessAction implements CancelSicknessActionInterface
{
    public function __construct(
        protected DeleteSicknessActionInterface $deleteSickness,
        protected CreateNotificationAction $createNotification,
        protected SendEmailNotificationAction $sendEmail
    ) {
        //
    }

    public function execute(Sickness $sickness, SicknessData $data): bool
    {
        $deleted = $this->deleteSickness->execute($sickness);
        $manager = $data->person->manager;

        if ($deleted && $manager) {
            $this->createNotification->execute(
                new NotificationData(
                    body: "Sickness for {$data->person->full_name}, starting at {$data->start_at->toDateString()} has been cancelled.",
                    notifiable_id: $manager->id,
                    notifiable_type: NotifiableType::PERSON,
                    title: 'Sickness Cancelled'
                )
            );

            $this->sendEmail->execute(
                new EmailNotificationData(
                    recipients: [$manager->user->email],
                    subject: 'Sickness Cancelled',
                    body: "Sickness for {$data->person->full_name}, starting at {$data->start_at->toDateString()} has been cancelled."
                )
            );
        }

        return $deleted;
    }
}
