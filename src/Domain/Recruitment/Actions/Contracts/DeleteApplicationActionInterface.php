<?php

namespace Domain\Recruitment\Actions\Contracts;

use Domain\Recruitment\Models\Application;

interface DeleteApplicationActionInterface
{
    public function execute(Application $application): bool;
}
