<?php

namespace Support\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Support\Contracts\ActionableEvent;

class LogAction
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle(ActionableEvent $event): void
    {
        //
    }
}
