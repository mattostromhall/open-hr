<?php

namespace Domain\Recruitment\Actions;

use Domain\Recruitment\Actions\Contracts\DeleteApplicationActionInterface;
use Domain\Recruitment\Models\Application;

class DeleteApplicationAction implements DeleteApplicationActionInterface
{
    public function execute(Application $application): bool
    {
        return $application->delete();
    }
}
