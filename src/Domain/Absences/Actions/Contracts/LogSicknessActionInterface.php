<?php

namespace Domain\Absences\Actions\Contracts;

use Domain\Absences\DataTransferObjects\LoggedSicknessData;
use Domain\Absences\Models\Sickness;

interface LogSicknessActionInterface
{
    public function execute(LoggedSicknessData $data): Sickness;
}
