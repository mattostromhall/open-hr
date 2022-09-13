<?php

namespace Domain\Performance\Actions;

use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\Actions\SendEmailNotificationAction;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Performance\DataTransferObjects\TrainingData;
use Domain\Performance\Models\Training;

class RequestTrainingReviewAction
{
    public function __construct(
        protected CreateNotificationAction $createNotification,
        protected SendEmailNotificationAction $sendEmail
    ) {
        //
    }

    public function execute(Training $training, TrainingData $data): void
    {
        $manager = $data->person->manager;

        if (! $manager) {
            return;
        }

        $this->createNotification->execute(
            new NotificationData(
                body: "Training requested by {$data->person->fullName}, click here to review.",
                notifiable_id: $manager->id,
                notifiable_type: 'person',
                title: 'New Training request',
                link: route('training.review.show', [
                    'training' => $training
                ])
            )
        );

        $this->sendEmail->execute(
            new EmailNotificationData(
                recipients: [$manager->user->email],
                subject: 'New Training request',
                body: "Training requested by {$data->person->fullName}, click here to review.",
                link: route('training.review.show', [
                    'training' => $training
                ])
            )
        );
    }
}
