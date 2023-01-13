<?php

namespace Domain\Performance\Actions;

use Domain\Performance\Actions\Contracts\CompleteObjectiveActionInterface;
use Domain\Performance\Models\Objective;

class CompleteObjectiveAction implements CompleteObjectiveActionInterface
{
    public function execute(Objective $objective): bool
    {
        return $objective->update([
            'completed_at' => now()
        ]);
    }
}
