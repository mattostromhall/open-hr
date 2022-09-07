<?php

namespace Domain\Performance\Actions;

use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\Models\Objective;

class UpdateObjectiveAction
{
    public function execute(Objective $objective, ObjectiveData $data): bool
    {
        return $objective->update([
            'person_id' => $data->person->id,
            'title' => $data->title,
            'description' => $data->description,
            'due_at' => $data->due_at,
            'completed_at' => $data->completed_at
        ]);
    }
}
