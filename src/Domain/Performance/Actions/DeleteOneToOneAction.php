<?php

namespace Domain\Performance\Actions;

use Domain\Performance\Actions\Contracts\DeleteOneToOneActionInterface;
use Domain\Performance\Models\OneToOne;

class DeleteOneToOneAction implements DeleteOneToOneActionInterface
{
    public function execute(OneToOne $oneToOne): bool
    {
        return $oneToOne->delete();
    }
}
