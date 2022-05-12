<?php

namespace Domain\Absences\DataTransferObjects;

use Domain\People\Models\Person;

class HolidayData
{
    public function __construct(
        public readonly Person $person,
        public readonly int $status,
        public readonly int $duration,
        public readonly string $start_at,
        public readonly string $end_at,
        public readonly bool $half_day,
        public readonly ?string $notes
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
