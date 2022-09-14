<?php

namespace Domain\Performance\Actions;

use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;
use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\Actions\SendEmailNotificationAction;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Performance\DataTransferObjects\TrainingData;
use Domain\Performance\Models\Training;

class ReviewTrainingAction
{
    public function __construct(
        protected UpdateTrainingAction $updateTraining,
        protected CreateNotificationAction $createNotification,
        protected SendEmailNotificationAction $sendEmail
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
                    notifiable_type: 'person',
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
                    link: route('training.review.show', [
                        'training' => $training
                    ])
                )
            );
        }

        return $updated;
    }
}
