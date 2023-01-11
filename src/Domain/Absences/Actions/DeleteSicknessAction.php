<?php

namespace Domain\Absences\Actions;

use Domain\Absences\Actions\Contracts\DeleteSicknessActionInterface;
use Domain\Absences\Models\Sickness;

class DeleteSicknessAction implements DeleteSicknessActionInterface
{
    public function execute(Sickness $sickness): bool
    {
        return $sickness->delete();
    }
}
