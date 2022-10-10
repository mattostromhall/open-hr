<?php

namespace Domain\Recruitment\Events;

use Domain\People\Models\Person;
use Domain\Recruitment\Models\Vacancy;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Support\Contracts\ActionableEvent;
use Support\Enums\Action;

class VacancyCreated implements ActionableEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public ?Person $person;

    public function __construct(public Vacancy $vacancy)
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
        return Action::CREATED;
    }

    public function payload(): string
    {
        return $this->vacancy->toJson();
    }

    public function actionableId(): int
    {
        return $this->vacancy->id;
    }

    public function actionableType(): string
    {
        return 'vacancy';
    }
}
