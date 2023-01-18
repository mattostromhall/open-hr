<?php

namespace Support\Actions;

use Support\Actions\Contracts\CreateActionLogActionInterface;
use Support\DataTransferObjects\ActionLogData;
use Support\Models\ActionLog;

class CreateActionLogAction implements CreateActionLogActionInterface
{
    public function execute(ActionLogData $data): ActionLog
    {
        return ActionLog::create([
            'person_id' => $data->person?->id,
            'action' => $data->action,
            'payload' => $data->payload,
            'actionable_id' => $data->actionable_id,
            'actionable_type' => $data->actionable_type
        ]);
    }
}
