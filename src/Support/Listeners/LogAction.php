<?php

namespace Support\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Support\Actions\CreateActionLogAction;
use Support\Contracts\ActionableEvent;
use Support\DataTransferObjects\ActionLogData;

class LogAction implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(protected CreateActionLogAction $createActionLog)
    {
        //
    }

    public function handle(ActionableEvent $event): void
    {
        $this->createActionLog->execute(
            new ActionLogData(
                person: $event->person(),
                action: $event->action(),
                payload: $event->payload(),
                actionable_id: $event->actionableId(),
                actionable_type: $event->actionableType()
            )
        );
    }
}
