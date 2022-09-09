<?php

namespace App\Http\Performance\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Performance\Enums\RecurrenceInterval;
use Domain\Performance\Models\Objective;
use Domain\Performance\Models\OneToOne;
use Illuminate\Support\Collection;

class ObjectiveViewModel extends ViewModel
{
    public function __construct(protected Objective $objective)
    {
        //
    }

    public function objective(): Objective
    {
        return $this->objective;
    }

    public function tasks()
    {
        return $this->objective->tasks;
    }

    public function person()
    {
        return $this->objective
            ->person
            ->only('first_name', 'last_name', 'full_name');
    }
}
