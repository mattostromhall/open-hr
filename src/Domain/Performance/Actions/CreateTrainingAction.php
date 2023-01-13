<?php

namespace Domain\Performance\Actions;

use Domain\Performance\Actions\Contracts\CreateTrainingActionInterface;
use Domain\Performance\DataTransferObjects\TrainingData;
use Domain\Performance\Models\Training;

class CreateTrainingAction implements CreateTrainingActionInterface
{
    public function execute(TrainingData $data): Training
    {
        return Training::create([
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
