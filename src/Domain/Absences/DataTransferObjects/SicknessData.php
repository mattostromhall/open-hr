<?php

namespace Domain\Absences\DataTransferObjects;

use Domain\People\Models\Person;
use Illuminate\Support\Carbon;

class SicknessData
{
    public function __construct(
        public readonly Person $person,
        public readonly Carbon $start_at,
        public readonly ?Carbon $finish_at = null,
        public readonly ?string $notes = null
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
