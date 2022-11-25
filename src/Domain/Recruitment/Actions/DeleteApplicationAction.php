<?php

namespace Domain\Recruitment\Actions;

use Domain\Recruitment\Models\Application;

class DeleteApplicationAction
{
    public function execute(Application $application): bool
    {
        return $application->delete();
    }
}
