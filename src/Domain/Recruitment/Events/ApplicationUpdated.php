<?php

namespace Domain\Recruitment\Events;

use Domain\People\Models\Person;
use Domain\Performance\Models\Task;
use Domain\Recruitment\Models\Application;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Support\Contracts\ActionableEvent;
use Support\Enums\Action;

class ApplicationUpdated implements ActionableEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public ?Person $person;

    public function __construct(public Application $application)
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
        return Action::UPDATED;
    }

    public function payload(): string
    {
        return $this->application->toJson();
    }

    public function actionableId(): int
    {
        return $this->application->id;
    }

    public function actionableType(): string
    {
        return 'application';
    }
}
