<?php

namespace Domain\Performance\Actions;

use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\Actions\SendEmailNotificationAction;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Performance\DataTransferObjects\TaskData;
use Domain\Performance\Models\Task;
use Illuminate\Support\Str;

class UnsetTaskAction
{
    public function __construct(
        protected DeleteTaskAction $deleteTask,
        protected CreateNotificationAction $createNotification,
        protected SendEmailNotificationAction $sendEmail
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
                    notifiable_type: 'person',
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
