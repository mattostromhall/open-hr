<?php

namespace Domain\Organisation\Actions;

use Domain\Organisation\Models\Organisation;

class CompleteSetupAction
{
    public function execute()
    {
        Organisation::first()->update([
            'set_up' => now()
        ]);
    }
}
