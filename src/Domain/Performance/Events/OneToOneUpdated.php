<?php

namespace Domain\Performance\Events;

use Domain\People\Models\Person;
use Domain\Performance\Models\OneToOne;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Support\Contracts\ActionableEvent;
use Support\Enums\Action;

class OneToOneUpdated implements ActionableEvent
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

    public function __construct(public OneToOne $oneToOne)
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
        return Action::UPDATED;
    }

    public function payload(): string
    {
        return $this->oneToOne->toJson();
    }

    public function actionableId(): int
    {
        return $this->oneToOne->id;
    }

    public function actionableType(): string
    {
        return 'one-to-one';
    }
}
