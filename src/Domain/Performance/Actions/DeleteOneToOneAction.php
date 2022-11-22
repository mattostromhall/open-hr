<?php

namespace Domain\Performance\Actions;

use Domain\Performance\Models\OneToOne;

class DeleteOneToOneAction
{
    public function execute(OneToOne $oneToOne): bool
    {
        return $oneToOne->delete();
    }
}
