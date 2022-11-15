<?php

namespace Domain\Absences\Actions;

use Domain\Absences\Models\Sickness;

class DeleteSicknessAction
{
    public function execute(Sickness $sickness): bool
    {
        return $sickness->delete();
    }
}
