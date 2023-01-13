<?php

namespace Domain\Recruitment\Actions\Contracts;

use Domain\Recruitment\DataTransferObjects\ApplicationData;
use Domain\Recruitment\Models\Application;

interface CreateApplicationActionInterface
{
    public function execute(ApplicationData $data): Application;
}
