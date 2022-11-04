<?php

namespace Domain\Performance\Actions;

use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Models\OneToOne;

class CreateOneToOneRecurrenceAction
{
    public function __construct(protected ScheduleOneToOneAction $scheduleOneToOne)
    {
        //
    }

    public function execute(OneToOneData $data): ?OneToOne
    {
        if (! $data->recurring || ! $data->completed_at) {
            return null;
        }

        return $this->scheduleOneToOne->execute($data);
    }
}
