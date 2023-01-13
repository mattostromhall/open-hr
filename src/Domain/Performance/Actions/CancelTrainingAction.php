<?php

namespace Domain\Performance\Actions;

use Domain\Notifications\Actions\Contracts\CreateNotificationActionInterface;
use Domain\Notifications\Actions\Contracts\SendEmailNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Domain\Performance\Actions\Contracts\CancelTrainingActionInterface;
use Domain\Performance\Actions\Contracts\DeleteTrainingActionInterface;
use Domain\Performance\DataTransferObjects\TrainingData;
use Domain\Performance\Models\Training;

class CancelTrainingAction implements CancelTrainingActionInterface
{
    public function __construct(
        protected DeleteTrainingActionInterface $deleteTraining,
        protected CreateNotificationActionInterface $createNotification,
        protected SendEmailNotificationActionInterface $sendEmail
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
                notifiable_type: NotifiableType::PERSON,
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
