<?php

namespace Domain\Performance\Actions;

use Domain\Performance\Enums\OneToOneStatus;
use Domain\Performance\Models\OneToOne;

class CompleteOneToOneAction
{
    public function execute(OneToOne $oneToOne): bool
    {
        return $oneToOne->update([
            'person_status' => OneToOneStatus::ACCEPTED,
            'manager_status' => OneToOneStatus::ACCEPTED,
            'completed_at' => now()
        ]);
    }
}
