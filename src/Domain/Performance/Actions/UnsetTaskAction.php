<?php

namespace Domain\Performance\Actions;

use Domain\Notifications\Actions\Contracts\CreateNotificationActionInterface;
use Domain\Notifications\Actions\Contracts\SendEmailNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Domain\Performance\Actions\Contracts\DeleteTaskActionInterface;
use Domain\Performance\Actions\Contracts\UnsetTaskActionInterface;
use Domain\Performance\DataTransferObjects\TaskData;
use Domain\Performance\Models\Task;
use Illuminate\Support\Str;

class UnsetTaskAction implements UnsetTaskActionInterface
{
    public function __construct(
        protected DeleteTaskActionInterface $deleteTask,
        protected CreateNotificationActionInterface $createNotification,
        protected SendEmailNotificationActionInterface $sendEmail
    ) {
        //
    }

    public function execute(Task $task, TaskData $data): bool
    {
        $deleted = $this->deleteTask->execute($task);

        if ($deleted) {
            $this->createNotification->execute(
                new NotificationData(
                    body: 'A Task has been unset - ' . Str::substr($data->description, 0, 75) . "... Deadline - {$data->due_at->toDateString()}",
                    notifiable_id: $data->objective->person->id,
                    notifiable_type: NotifiableType::PERSON,
                    title: 'A Task has been unset',
                )
            );

            $this->sendEmail->execute(
                new EmailNotificationData(
                    recipients: [$data->objective->person->user->email],
                    subject: 'A Task has been unset',
                    body: "A Task has been unset - {$data->description}. Deadline - {$data->due_at->toDateString()}"
                )
            );
        }

        return $deleted;
    }
}
