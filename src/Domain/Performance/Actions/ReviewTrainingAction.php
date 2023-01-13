<?php

namespace Domain\Performance\Actions;

use Domain\Notifications\Actions\Contracts\CreateNotificationActionInterface;
use Domain\Notifications\Actions\Contracts\SendEmailNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Domain\Performance\Actions\Contracts\ReviewTrainingActionInterface;
use Domain\Performance\Actions\Contracts\UpdateTrainingActionInterface;
use Domain\Performance\DataTransferObjects\TrainingData;
use Domain\Performance\Models\Training;

class ReviewTrainingAction implements ReviewTrainingActionInterface
{
    public function __construct(
        protected UpdateTrainingActionInterface $updateTraining,
        protected CreateNotificationActionInterface $createNotification,
        protected SendEmailNotificationActionInterface $sendEmail
    ) {
        //
    }

    public function execute(Training $training, TrainingData $data): bool
    {
        $updated = $this->updateTraining->execute($training, $data);

        if ($updated) {
            $this->createNotification->execute(
                new NotificationData(
                    body: "Your Training request has been updated to {$data->status->statusDisplay()}",
                    notifiable_id: $data->person->id,
                    notifiable_type: NotifiableType::PERSON,
                    title: 'Training request reviewed',
                    link: route('training.show', [
                        'training' => $training
                    ])
                )
            );

            $this->sendEmail->execute(
                new EmailNotificationData(
                    recipients: [$data->person->user->email],
                    subject: 'Training request reviewed',
                    body: "Your Training request has been updated to {$data->status->statusDisplay()}",
                    link: route('training.show', [
                        'training' => $training
                    ])
                )
            );
        }

        return $updated;
    }
}
