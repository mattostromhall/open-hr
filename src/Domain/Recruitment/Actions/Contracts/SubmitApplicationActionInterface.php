<?php

namespace Domain\Recruitment\Actions\Contracts;

use Domain\Recruitment\DataTransferObjects\SubmittedApplicationData;
use Domain\Recruitment\Models\Application;

interface SubmitApplicationActionInterface
{
    public function execute(SubmittedApplicationData $data): Application;
}
