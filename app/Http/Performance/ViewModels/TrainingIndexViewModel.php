<?php

namespace App\Http\Performance\ViewModels;

use App\Http\Support\ViewModels\ViewModel;

class TrainingIndexViewModel extends ViewModel
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
