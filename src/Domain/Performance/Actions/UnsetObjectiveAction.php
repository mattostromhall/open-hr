<?php

namespace Domain\Performance\Actions;

use Domain\Notifications\Actions\Contracts\CreateNotificationActionInterface;
use Domain\Notifications\Actions\Contracts\SendEmailNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Domain\Performance\Actions\Contracts\DeleteObjectiveActionInterface;
use Domain\Performance\Actions\Contracts\UnsetObjectiveActionInterface;
use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\Models\Objective;

class UnsetObjectiveAction implements UnsetObjectiveActionInterface
{
    public function __construct(
        protected DeleteObjectiveActionInterface $deleteObjective,
        protected CreateNotificationActionInterface $createNotification,
        protected SendEmailNotificationActionInterface $sendEmail
    ) {
        //
    }

    public function execute(Objective $objective, ObjectiveData $data): bool
    {
        $deleted = $this->deleteObjective->execute($objective);

        if ($deleted) {
            $this->createNotification->execute(
                new NotificationData(
                    body: "An Objective has been unset - {$data->title}. Deadline - {$data->due_at->toDateString()}",
                    notifiable_id: $data->person->id,
                    notifiable_type: NotifiableType::PERSON,
                    title: 'An Objective has been unset',
                )
            );

            $this->sendEmail->execute(
                new EmailNotificationData(
                    recipients: [$data->person->user->email],
                    subject: 'An Objective has been unset',
                    body: "An Objective has been unset - {$data->title}. Deadline - {$data->due_at->toDateString()}"
                )
            );
        }

        return $deleted;
    }
}
