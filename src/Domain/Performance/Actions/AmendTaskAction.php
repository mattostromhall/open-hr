<?php

namespace Domain\Performance\Actions;

use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Performance\DataTransferObjects\TaskData;
use Domain\Performance\Models\Task;

class AmendTaskAction
{
    public function __construct(
        protected UpdateTaskAction $updateTask,
        protected CreateNotificationAction $createNotification
    ) {
        //
    }

    public function execute(Task $task, TaskData $data): bool
    {
        $updated = $this->updateTask->execute($task, $data);

        if ($updated) {
            $this->createNotification->execute(
                new NotificationData(
                    body: "The task for objective {$data->objective->title} has been updated",
                    notifiable_id: $data->objective->person_id,
                    notifiable_type: 'person',
                    title: 'Task updated',
                    link: route('objective.show', [
                        'objective' => $data->objective
                    ])
                )
            );
        }

        return $updated;
    }
}