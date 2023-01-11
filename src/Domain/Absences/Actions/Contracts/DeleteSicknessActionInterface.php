<?php

namespace Domain\Absences\Actions\Contracts;

use Domain\Absences\Models\Sickness;

interface DeleteSicknessActionInterface
{
    public function execute(Sickness $sickness): bool;
}
