<?php

namespace Domain\Performance\Actions;

use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\Models\Objective;

class CreateObjectiveAction
{
    public function execute(ObjectiveData $data): Objective
    {
        return Objective::create([
            'person_id' => $data->person->id,
            'title' => $data->title,
            'description' => $data->description,
            'due_at' => $data->due_at,
            'completed_at' => $data->completed_at
        ]);
    }
}
