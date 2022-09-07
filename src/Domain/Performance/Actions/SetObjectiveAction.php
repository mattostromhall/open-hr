<?php

namespace Domain\Performance\Actions;

use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\Models\Objective;

class SetObjectiveAction
{
    public function __construct(
        protected CreateObjectiveAction $createObjective,
        protected CreateNotificationAction $createNotification
    ) {
        //
    }

    public function execute(ObjectiveData $data): Objective
    {
        $objective = $this->createObjective->execute($data);

        $this->createNotification->execute(
            new NotificationData(
                body: "A new objective has been set - {$data->title}. Deadline - {$data->due_at->toDateString()}",
                notifiable_id: $data->person->id,
                notifiable_type: 'person',
                title: 'A new objective has been set',
                link: route('objective.show', [
                    'objective' => $objective
                ])
            )
        );

        return $objective;
    }
}
