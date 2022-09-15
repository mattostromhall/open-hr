<?php

namespace App\Http\Performance\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Performance\Models\Training;

class TrainingViewModel extends ViewModel
{
    public function __construct(protected Training $training)
    {
        //
    }

    public function training(): Training
    {
        return $this->training;
    }

    public function person()
    {
        return $this->training
            ->person
            ->only('first_name', 'last_name', 'full_name');
    }

    public function status()
    {
        return $this->training->status->statusDisplay();
    }

    public function state()
    {
        return $this->training->state->stateDisplay();
    }
}
