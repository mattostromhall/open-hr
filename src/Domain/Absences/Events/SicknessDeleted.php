<?php

namespace Domain\Absences\Events;

use Domain\Absences\Models\Sickness;
use Domain\People\Models\Person;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Support\Contracts\ActionableEvent;
use Support\Enums\Action;

class SicknessDeleted implements ActionableEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public ?Person $person;

    public function __construct(public Sickness $sickness)
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
        return $this->sickness->toJson();
    }

    public function actionableId(): int
    {
        return $this->sickness->id;
    }

    public function actionableType(): string
    {
        return 'sickness';
    }
}
