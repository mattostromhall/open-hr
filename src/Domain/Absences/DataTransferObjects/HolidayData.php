<?php

namespace Domain\Absences\DataTransferObjects;

use Domain\Absences\Enums\HalfDay;
use Domain\Absences\Enums\HolidayStatus;
use Domain\People\Models\Person;
use Illuminate\Support\Carbon;

class HolidayData
{
    public function __construct(
        public readonly Person $person,
        public readonly HolidayStatus $status,
        public readonly Carbon $start_at,
        public readonly Carbon $finish_at,
        public readonly ?HalfDay $half_day,
        public readonly ?string $notes
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
