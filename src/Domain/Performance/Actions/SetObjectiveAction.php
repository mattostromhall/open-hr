<?php

namespace Domain\Performance\Actions;

use Domain\Notifications\Actions\Contracts\CreateNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\Models\Objective;

class SetObjectiveAction
{
    public function __construct(
        protected CreateObjectiveAction $createObjective,
        protected CreateNotificationActionInterface $createNotification
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
                notifiable_type: NotifiableType::PERSON,
                title: 'A new objective has been set',
                link: route('objective.show', [
                    'objective' => $objective
                ])
            )
        );

        return $objective;
    }
}
