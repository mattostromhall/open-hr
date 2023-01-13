<?php

namespace Domain\Performance\Actions\Contracts;

use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Models\OneToOne;

interface OneToOneInviteActionInterface
{
    public function execute(OneToOne $oneToOne, OneToOneData $data): void;
}
