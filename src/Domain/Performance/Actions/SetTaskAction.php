<?php

namespace Domain\Performance\Actions;

use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Domain\Performance\DataTransferObjects\TaskData;
use Domain\Performance\Models\Task;

class SetTaskAction
{
    public function __construct(
        protected CreateTaskAction $createTask,
        protected CreateNotificationAction $createNotification
    ) {
        //
    }

    public function execute(TaskData $data): Task
    {
        $task = $this->createTask->execute($data);

        $this->createNotification->execute(
            new NotificationData(
                body: "A new task has been set on Objective - {$data->objective->title}. Deadline - {$data->due_at->toDateString()}",
                notifiable_id: $data->objective->person->id,
                notifiable_type: NotifiableType::PERSON,
                title: 'A new Task has been set for an Objective',
                link: route('objective.show', [
                    'objective' => $data->objective
                ])
            )
        );

        return $task;
    }
}
