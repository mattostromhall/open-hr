<?php

namespace Domain\Absences\Actions\Contracts;

use Domain\Absences\DataTransferObjects\LoggedSicknessData;
use Domain\Absences\Models\Sickness;

interface AmendSicknessActionInterface
{
    public function execute(Sickness $sickness, LoggedSicknessData $data): bool;
}
