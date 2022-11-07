<?php

namespace Domain\Performance\DataTransferObjects;

use Domain\People\Models\Person;
use Illuminate\Support\Carbon;
use Support\DataTransferObjects\DataTransferObject;

class ObjectiveData extends DataTransferObject
{
    public function __construct(
        public readonly Person $person,
        public readonly string $title,
        public readonly string $description,
        public readonly Carbon $due_at,
        public readonly ?Carbon $completed_at = null
    ) {
        //
    }
}
