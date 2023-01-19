<?php

namespace Domain\Organisation\Actions;

use Domain\Organisation\Actions\Contracts\CompleteSetupActionInterface;
use Domain\Organisation\Models\Organisation;
use Illuminate\Support\Facades\Artisan;

class CompleteSetupAction implements CompleteSetupActionInterface
{
    public function execute()
    {
        Artisan::call('scaffold:defaults');

        Organisation::first()->update([
            'setup_at' => now()
        ]);
    }
}
