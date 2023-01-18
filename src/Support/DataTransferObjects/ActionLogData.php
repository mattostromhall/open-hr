<?php

namespace Support\DataTransferObjects;

use Domain\People\Models\Person;
use Support\Enums\Action;

class ActionLogData extends DataTransferObject
{
    public function __construct(
        public readonly Action $action,
        public readonly string $payload,
        public readonly int $actionable_id,
        public readonly string $actionable_type,
        public readonly ?Person $person = null,
    ) {
        //
    }
}
