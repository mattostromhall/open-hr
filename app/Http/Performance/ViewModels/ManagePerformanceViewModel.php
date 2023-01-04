<?php

namespace App\Http\Performance\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Performance\Enums\RecurrenceInterval;
use Illuminate\Support\Collection;

class ManagePerformanceViewModel extends ViewModel
{
    public function active(): string
    {
        return request()->query('active', 'schedule');
    }

    public function directReports()
    {
        return person()->directReports->map(
            fn ($directReport) => $directReport->only('id', 'full_name')
        );
    }

    public function recurrenceIntervals(): Collection
    {
        return RecurrenceInterval::all();
    }

    public function upcomingOneToOnes()
    {
        return person()
            ->managerOneToOnes()
            ->upcoming()
            ->get();
    }

    public function previousOneToOnes()
    {
        return person()
            ->managerOneToOnes()
            ->previous()
            ->get();
    }
}
