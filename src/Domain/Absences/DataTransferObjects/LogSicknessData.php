<?php

namespace Domain\Absences\DataTransferObjects;

use Illuminate\Support\Collection;

class LogSicknessData
{
    public function __construct(
        public readonly SicknessData $sickness_data,
        public readonly ?Collection $documents = null
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
