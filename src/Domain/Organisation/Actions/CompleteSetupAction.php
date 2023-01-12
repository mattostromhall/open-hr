<?php

namespace Domain\Organisation\Actions;

use Domain\Organisation\Actions\Contracts\CompleteSetupActionInterface;
use Domain\Organisation\Models\Organisation;

class CompleteSetupAction implements CompleteSetupActionInterface
{
    public function execute()
    {
        Organisation::first()->update([
            'setup_at' => now()
        ]);
    }
}
