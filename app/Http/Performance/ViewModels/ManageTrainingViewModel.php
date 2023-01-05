<?php

namespace App\Http\Performance\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Performance\Enums\RecurrenceInterval;
use Illuminate\Support\Collection;

class ManageTrainingViewModel extends ViewModel
{
    public function active(): string
    {
        return request()->query('active', 'request');
    }

    public function started()
    {
        return person()
            ->training()
            ->approved()
            ->started()
            ->get();
    }

    public function notStarted()
    {
        return person()
            ->training()
            ->approved()
            ->notStarted()
            ->get();
    }

    public function completed()
    {
        return person()
            ->training()
            ->approved()
            ->completed()
            ->get();
    }

    public function awaitingApproval()
    {
        return person()
            ->training()
            ->awaitingApproval()
            ->get();
    }
}
