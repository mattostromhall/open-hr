<?php

namespace Domain\Performance\DataTransferObjects;

use Domain\People\Models\Person;
use Domain\Performance\Enums\TrainingState;
use Domain\Performance\Enums\TrainingStatus;
use Support\Enums\Currency;

class TrainingData
{
    public function __construct(
        public readonly Person $person,
        public readonly TrainingStatus $status,
        public readonly TrainingState $state,
        public readonly string $provider,
        public readonly string $description,
        public readonly ?string $location = null,
        public readonly ?int $cost = null,
        public readonly ?Currency $cost_currency = null,
        public readonly ?int $duration = null,
        public readonly ?string $notes = null
    ) {
        //
    }

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
