<?php

namespace Support\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Support\Actions\Contracts\CreateActionLogActionInterface;
use Support\Contracts\ActionableEvent;
use Support\DataTransferObjects\ActionLogData;

class LogAction implements ShouldQueue
{
    public function __construct(protected CreateActionLogActionInterface $createActionLog)
    {
        //
    }

    public function handle(ActionableEvent $event): void
    {
        $this->createActionLog->execute(
            new ActionLogData(
                action: $event->action(),
                payload: $event->payload(),
                actionable_id: $event->actionableId(),
                actionable_type: $event->actionableType(),
                person: $event->person()
            )
        );
    }
}
