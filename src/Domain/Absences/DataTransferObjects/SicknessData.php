<?php

namespace Domain\Absences\DataTransferObjects;

use Domain\People\Models\Person;

class SicknessData
{
    public function __construct(
        public readonly Person $person,
        public readonly string $start_at,
        public readonly ?string $finish_at,
        public readonly ?string $notes
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
