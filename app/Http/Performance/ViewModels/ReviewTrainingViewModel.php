<?php

namespace App\Http\Performance\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Performance\Models\Training;

class ReviewTrainingViewModel extends ViewModel
{
    public function __construct(protected Training $training)
    {
        //
    }

    public function requester(): string
    {
        return $this->training
            ->person
            ->fullName;
    }

    public function training(): Training
    {
        return $this->training;
    }

    public function status(): string
    {
        return $this->training->status->statusDisplay();
    }
}
