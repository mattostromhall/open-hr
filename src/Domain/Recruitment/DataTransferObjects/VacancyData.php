<?php

namespace Domain\Recruitment\DataTransferObjects;

class VacancyData
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly int $remuneration,
        public readonly string $contact,
        public readonly string $open_at,
        public readonly ?string $close_at
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
