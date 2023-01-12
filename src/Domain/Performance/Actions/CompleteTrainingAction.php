<?php

namespace Domain\Performance\Actions;

use Domain\Notifications\Actions\Contracts\CreateNotificationActionInterface;
use Domain\Notifications\Actions\Contracts\SendEmailNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Domain\Performance\Enums\TrainingState;
use Domain\Performance\Models\Training;

class CompleteTrainingAction
{
    public function __construct(
        protected CreateNotificationActionInterface $createNotification,
        protected SendEmailNotificationActionInterface $sendEmail
    ) {
        //
    }

    public function execute(Training $training): bool
    {
        $updated = $training->update([
            'state' => TrainingState::COMPLETED
        ]);

        $manager = $training->person->manager;

        if ($manager) {
            $this->createNotification->execute(
                new NotificationData(
                    body: "Training - {$training->description} completed by {$training->person->fullName}",
                    notifiable_id: $manager->id,
                    notifiable_type: NotifiableType::PERSON,
                    title: 'Training completed',
                    link: route('training.show', [
                        'training' => $training
                    ])
                )
            );

            $this->sendEmail->execute(
                new EmailNotificationData(
                    recipients: [$manager->user->email],
                    subject: 'Training completed',
                    body: "Training - {$training->description} completed by {$training->person->fullName}",
                    link: route('training.show', [
                        'training' => $training
                    ])
                )
            );
        }

        return $updated;
    }
}
