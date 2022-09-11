<?php

namespace Domain\Performance\Actions;

use Domain\Performance\Models\Objective;

class CompleteObjectiveAction
{
    public function execute(Objective $objective): bool
    {
        return $objective->update([
            'completed_at' => now()
        ]);
    }
}
