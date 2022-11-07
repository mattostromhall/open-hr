<?php

namespace Domain\Absences\DataTransferObjects;

use Domain\People\Models\Person;
use Illuminate\Support\Carbon;
use Support\DataTransferObjects\DataTransferObject;

class SicknessData extends DataTransferObject
{
    public function __construct(
        public readonly Person $person,
        public readonly Carbon $start_at,
        public readonly ?Carbon $finish_at = null,
        public readonly ?string $notes = null
    ) {
        //
    }
}
