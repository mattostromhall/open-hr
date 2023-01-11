<?php

namespace Domain\Absences\Actions;

use Domain\Absences\Actions\Contracts\UpdateSicknessActionInterface;
use Domain\Absences\DataTransferObjects\SicknessData;
use Domain\Absences\Models\Sickness;

class UpdateSicknessAction implements UpdateSicknessActionInterface
{
    public function execute(Sickness $sickness, SicknessData $data): bool
    {
        return $sickness->update([
            'start_at' => $data->start_at,
            'finish_at' => $data->finish_at,
            'notes' => $data->notes
        ]);
    }
}
