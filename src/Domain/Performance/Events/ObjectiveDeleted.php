<?php

namespace Domain\Performance\Events;

use Domain\People\Models\Person;
use Domain\Performance\Models\Objective;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Support\Contracts\ActionableEvent;
use Support\Enums\Action;

class ObjectiveDeleted implements ActionableEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public Person $person;

    public function __construct(public Objective $objective)
    {
        $this->person = person();
    }

    public function broadcastOn(): Channel|PrivateChannel|array
    {
        return new PrivateChannel('channel-name');
    }

    public function person(): Person
    {
        return $this->person;
    }

    public function action(): Action
    {
        return Action::DELETED;
    }

    public function payload(): string
    {
        return $this->objective->toJson();
    }

    public function actionableId(): int
    {
        return $this->objective->id;
    }

    public function actionableType(): string
    {
        return 'objective';
    }
}
