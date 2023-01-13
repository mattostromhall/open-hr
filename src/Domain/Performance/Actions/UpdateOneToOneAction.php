<?php

namespace Domain\Performance\Actions;

use Domain\Performance\Actions\Contracts\UpdateOneToOneActionInterface;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Models\OneToOne;

class UpdateOneToOneAction implements UpdateOneToOneActionInterface
{
    public function execute(OneToOne $oneToOne, OneToOneData $data): bool
    {
        return $oneToOne->update([
            'person_status' => $data->person_status,
            'manager_status' => $data->manager_status,
            'scheduled_at' => $data->scheduled_at,
            'recurring' => $data->recurring,
            'recurrence_interval' => $data->recurrence_interval,
            'completed_at' => $data->completed_at,
            'notes' => $data->notes
        ]);
    }
}
