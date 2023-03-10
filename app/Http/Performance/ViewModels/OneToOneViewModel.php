<?php

namespace App\Http\Performance\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Performance\Enums\RecurrenceInterval;
use Domain\Performance\Models\OneToOne;
use Illuminate\Support\Collection;

class OneToOneViewModel extends ViewModel
{
    public function __construct(protected OneToOne $oneToOne)
    {
        //
    }

    public function oneToOne(): OneToOne
    {
        return $this->oneToOne;
    }

    public function requester(): string
    {
        return $this->oneToOne->requester->full_name;
    }

    public function personName()
    {
        return $this->oneToOne->person->full_name;
    }

    public function managerName()
    {
        return $this->oneToOne->manager->full_name;
    }

    public function personStatus(): string
    {
        return $this->oneToOne->person_status->statusDisplay();
    }

    public function managerStatus(): string
    {
        return $this->oneToOne->manager_status->statusDisplay();
    }

    public function recurrenceIntervals(): Collection
    {
        return RecurrenceInterval::all();
    }
}
