<?php

namespace Domain\Performance\Actions;

use Domain\Performance\Actions\Contracts\CreateOneToOneActionInterface;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Models\OneToOne;

class CreateOneToOneAction implements CreateOneToOneActionInterface
{
    public function execute(OneToOneData $data): OneToOne
    {
        return OneToOne::create([
            'person_id' => $data->person->id,
            'manager_id' => $data->manager->id,
            'requester_id' => $data->requester_id,
            'person_status' => $data->person_status,
            'manager_status' => $data->manager_status,
            'scheduled_at' => $data->scheduled_at,
            'completed_at' => $data->completed_at,
            'recurring' => $data->recurring,
            'recurrence_interval' => $data->recurrence_interval,
            'notes' => $data->notes
        ]);
    }
}
