<?php

namespace Support\DataTransferObjects;

use Domain\People\Models\Person;
use Support\Enums\Action;

class ActionLogData
{
    public function __construct(
        public readonly Person $person,
        public readonly Action $action,
        public readonly string $payload,
        public readonly int $actionable_id,
        public readonly string $actionable_type
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
