<?php

namespace Domain\Performance\Actions\Contracts;

use Domain\Performance\Models\OneToOne;

interface DeleteOneToOneActionInterface
{
    public function execute(OneToOne $oneToOne): bool;
}
