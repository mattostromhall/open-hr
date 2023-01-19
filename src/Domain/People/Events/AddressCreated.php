<?php

namespace Domain\People\Events;

use Domain\People\Models\Address;
use Domain\People\Models\Person;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Support\Contracts\ActionableEvent;
use Support\Enums\Action;

class AddressCreated implements ActionableEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public ?Person $person;

    public function __construct(public Address $address)
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
        return Action::CREATED;
    }

    public function payload(): string
    {
        return $this->address->toJson();
    }

    public function actionableId(): int
    {
        return $this->address->id;
    }

    public function actionableType(): string
    {
        return 'address';
    }
}
