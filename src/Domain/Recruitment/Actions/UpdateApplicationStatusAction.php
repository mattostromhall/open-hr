<?php

namespace Domain\Recruitment\Actions;

use Domain\Recruitment\DataTransferObjects\ApplicationData;
use Domain\Recruitment\Enums\ApplicationStatus;
use Domain\Recruitment\Models\Application;

class UpdateApplicationStatusAction
{
    public function execute(Application $application, ApplicationStatus $status): bool
    {
        return $application->update([
            'status' => $status
        ]);
    }
}
