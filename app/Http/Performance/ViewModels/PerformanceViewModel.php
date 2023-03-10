<?php

namespace App\Http\Performance\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Performance\Enums\RecurrenceInterval;
use Illuminate\Support\Collection;

class PerformanceViewModel extends ViewModel
{
    public function active(): string
    {
        return request()->query('active', 'request');
    }

    public function manager()
    {
        return person()->manager?->only('id', 'full_name')
            ?? person()->department?->head->only('id', 'full_name');
    }

    public function upcomingOneToOnes()
    {
        return person()
            ->oneToOnes()
            ->upcoming()
            ->get();
    }

    public function previousOneToOnes()
    {
        return person()
            ->oneToOnes()
            ->previous()
            ->get();
    }

    public function objectives()
    {
        return person()
            ->objectives()
            ->current()
            ->get();
    }
}
