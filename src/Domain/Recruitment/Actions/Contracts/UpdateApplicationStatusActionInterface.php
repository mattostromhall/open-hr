<?php

namespace Domain\Recruitment\Actions\Contracts;

use Domain\Recruitment\Enums\ApplicationStatus;
use Domain\Recruitment\Models\Application;

interface UpdateApplicationStatusActionInterface
{
    public function execute(Application $application, ApplicationStatus $status): bool;
}
