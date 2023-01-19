<?php

namespace Domain\Performance\Events;

use Domain\People\Models\Person;
use Domain\Performance\Models\Training;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Support\Contracts\ActionableEvent;
use Support\Enums\Action;

class TrainingDeleted implements ActionableEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public ?Person $person;

    public function __construct(public Training $training)
    {
        $this->person = person();
    }

    public function broadcastOn(): Channel|PrivateChannel|array
    {
        return new PrivateChannel('channel-name');
    }

    public function person(): ?Person
    {
        return $this->person;
    }

    public function action(): Action
    {
        return Action::DELETED;
    }

    public function payload(): string
    {
        return $this->training->toJson();
    }

    public function actionableId(): int
    {
        return $this->training->id;
    }

    public function actionableType(): string
    {
        return 'training';
    }
}
