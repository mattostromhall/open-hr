<?php

namespace Domain\Performance\Actions;

use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Models\OneToOne;

class CreateOneToOneAction
{
    public function execute(OneToOneData $data): OneToOne
    {
        return OneToOne::create([
            'person_id' => $data->person->id,
            'manager_id' => $data->manager->id,
            'requester_id' => $data->requester_id,
            'status' => $data->status,
            'scheduled_at' => $data->scheduled_at,
            'completed_at' => $data->completed_at,
            'recurring' => $data->recurring,
            'recurrence_interval' => $data->recurrence_interval,
            'notes' => $data->notes
        ]);
    }
}
