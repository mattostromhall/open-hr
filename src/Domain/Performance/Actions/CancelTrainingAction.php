<?php

namespace Domain\Performance\Actions;

use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\Actions\SendEmailNotificationAction;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Performance\DataTransferObjects\TrainingData;
use Domain\Performance\Models\Training;

class CancelTrainingAction
{
    public function __construct(
        protected DeleteTrainingAction $deleteTraining,
        protected CreateNotificationAction $createNotification,
        protected SendEmailNotificationAction $sendEmail
    ) {
        //
    }

    public function execute(Training $training, TrainingData $data): bool
    {
        $deleted = $this->deleteTraining->execute($training);

        $manager = $data->person->manager;

        if (! $manager) {
            return $deleted;
        }

        $this->createNotification->execute(
            new NotificationData(
                body: "Training request for {$data->person->fullName} - {$data->description} has been cancelled.",
                notifiable_id: $manager->id,
                notifiable_type: 'person',
                title: 'Training request cancelled'
            )
        );

        $this->sendEmail->execute(
            new EmailNotificationData(
                recipients: [$manager->user->email],
                subject: 'Training request cancelled',
                body: "Training request for {$data->person->fullName} - {$data->description} has been cancelled."
            )
        );

        return $deleted;
    }
}
