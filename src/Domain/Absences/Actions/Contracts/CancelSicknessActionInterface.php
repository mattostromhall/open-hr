<?php

namespace Domain\Absences\Actions\Contracts;

use Domain\Absences\DataTransferObjects\SicknessData;
use Domain\Absences\Models\Sickness;

interface CancelSicknessActionInterface
{
    public function execute(Sickness $sickness, SicknessData $data): bool;
}
