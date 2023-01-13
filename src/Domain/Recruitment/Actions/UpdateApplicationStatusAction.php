<?php

namespace Domain\Recruitment\Actions;

use Domain\Recruitment\Actions\Contracts\UpdateApplicationStatusActionInterface;
use Domain\Recruitment\Enums\ApplicationStatus;
use Domain\Recruitment\Models\Application;

class UpdateApplicationStatusAction implements UpdateApplicationStatusActionInterface
{
    public function execute(Application $application, ApplicationStatus $status): bool
    {
        return $application->update([
            'status' => $status
        ]);
    }
}
