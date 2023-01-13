<?php

namespace Support\Actions\Contracts;

use Support\DataTransferObjects\ActionLogData;
use Support\Models\ActionLog;

interface CreateActionLogActionInterface
{
    public function execute(ActionLogData $data): ActionLog;
}
