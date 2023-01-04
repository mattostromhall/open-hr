<?php

namespace Domain\Performance\Actions;

use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\Models\Objective;

class AmendObjectiveAction
{
    public function __construct(
        protected UpdateObjectiveAction $updateObjective,
        protected CreateNotificationAction $createNotification
    ) {
        //
    }

    public function execute(Objective $objective, ObjectiveData $data): bool
    {
        $updated = $this->updateObjective->execute($objective, $data);

        if ($updated) {
            $this->createNotification->execute(
                new NotificationData(
                    body: "The objective {$data->title} has been updated",
                    notifiable_id: $data->person->id,
                    notifiable_type: NotifiableType::PERSON,
                    title: 'Objective updated',
                    link: route('objective.show', [
                        'objective' => $objective
                    ])
                )
            );
        }

        return $updated;
    }
}
