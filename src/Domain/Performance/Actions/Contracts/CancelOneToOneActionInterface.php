<?php

namespace Domain\Performance\Actions\Contracts;

use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Models\OneToOne;

interface CancelOneToOneActionInterface
{
    public function execute(OneToOne $oneToOne, OneToOneData $data): bool;
}
