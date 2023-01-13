<?php

namespace Domain\Performance\Actions;

use Domain\Performance\Actions\Contracts\UpdateTrainingActionInterface;
use Domain\Performance\DataTransferObjects\TrainingData;
use Domain\Performance\Models\Training;

class UpdateTrainingAction implements UpdateTrainingActionInterface
{
    public function execute(Training $training, TrainingData $data): bool
    {
        return $training->update([
            'person_id' => $data->person->id,
            'status' => $data->status,
            'state' => $data->state,
            'provider' => $data->provider,
            'description' => $data->description,
            'location' => $data->location,
            'cost' => $data->cost,
            'cost_currency' => $data->cost_currency,
            'duration' => $data->duration,
            'notes' => $data->notes
        ]);
    }
}
