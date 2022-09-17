<?php

namespace Domain\Performance\Actions;

use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\Actions\SendEmailNotificationAction;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Performance\Enums\TrainingState;
use Domain\Performance\Models\Training;

class CompleteTrainingAction
{
    public function __construct(
        protected CreateNotificationAction $createNotification,
        protected SendEmailNotificationAction $sendEmail
    ) {
        //
    }

    public function execute(Training $training): bool
    {
        $updated = $training->update([
            'state' => TrainingState::COMPLETED
        ]);

        $this->createNotification->execute(
            new NotificationData(
                body: "Training - {$training->description} completed by {$training->person->fullName}",
                notifiable_id: $training->person->manager->id,
                notifiable_type: 'person',
                title: 'Training completed',
                link: route('training.show', [
                    'training' => $training
                ])
            )
        );

        $this->sendEmail->execute(
            new EmailNotificationData(
                recipients: [$training->person->manager->user->email],
                subject: 'Training completed',
                body: "Training - {$training->description} completed by {$training->person->fullName}",
                link: route('training.show', [
                    'training' => $training
                ])
            )
        );

        return $updated;
    }
}
