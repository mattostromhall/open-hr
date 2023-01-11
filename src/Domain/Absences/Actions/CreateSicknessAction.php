<?php

namespace Domain\Absences\Actions;

use Domain\Absences\Actions\Contracts\CreateSicknessActionInterface;
use Domain\Absences\DataTransferObjects\SicknessData;
use Domain\Absences\Models\Sickness;

class CreateSicknessAction implements CreateSicknessActionInterface
{
    public function execute(SicknessData $data): Sickness
    {
        return Sickness::create([
            'person_id' => $data->person->id,
            'start_at' => $data->start_at,
            'finish_at' => $data->finish_at,
            'notes' => $data->notes
        ]);
    }
}
