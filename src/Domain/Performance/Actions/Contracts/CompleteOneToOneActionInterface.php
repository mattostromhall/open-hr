<?php

namespace Domain\Performance\Actions\Contracts;

use Domain\Performance\Models\OneToOne;

interface CompleteOneToOneActionInterface
{
    public function execute(OneToOne $oneToOne): bool;
}
