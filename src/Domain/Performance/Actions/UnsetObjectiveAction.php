<?php

namespace Domain\Performance\Actions;

use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\Actions\SendEmailNotificationAction;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\Models\Objective;

class UnsetObjectiveAction
{
    public function __construct(
        protected DeleteObjectiveAction $deleteObjective,
        protected CreateNotificationAction $createNotification,
        protected SendEmailNotificationAction $sendEmail
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
