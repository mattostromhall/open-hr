<?php

namespace Domain\Performance\Actions;

use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Enums\OneToOneStatus;
use Domain\Performance\Models\OneToOne;
use Exception;

class CompleteOneToOneAction
{
    public function __construct(protected CreateOneToOneRecurrenceAction $createRecurrence)
    {
        //
    }

    public function execute(OneToOne $oneToOne): bool
    {
        $updated = $oneToOne->update([
            'person_status' => OneToOneStatus::ACCEPTED,
            'manager_status' => OneToOneStatus::ACCEPTED,
            'completed_at' => now()
        ]);

        if ($updated) {
            try {
                $this->createRecurrence->execute(OneToOneData::from($oneToOne->toArray()));
            } catch (Exception) {
                return false;
            }
        }

        return $updated;
    }
}
