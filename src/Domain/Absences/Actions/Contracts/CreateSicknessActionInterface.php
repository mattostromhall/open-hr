<?php

namespace Domain\Absences\Actions\Contracts;

use Domain\Absences\DataTransferObjects\SicknessData;
use Domain\Absences\Models\Sickness;

interface CreateSicknessActionInterface
{
    public function execute(SicknessData $data): Sickness;
}
