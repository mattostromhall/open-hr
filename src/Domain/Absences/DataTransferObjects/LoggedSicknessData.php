<?php

namespace Domain\Absences\DataTransferObjects;

use Illuminate\Support\Collection;
use Support\DataTransferObjects\DataTransferObject;

class LoggedSicknessData extends DataTransferObject
{
    public function __construct(
        public readonly SicknessData $sickness_data,
        public readonly ?Collection $documents = null
    ) {
        //
    }
}
