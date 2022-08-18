<?php

namespace App\Http\Performance\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Performance\Enums\RecurrenceInterval;
use Illuminate\Support\Collection;

class PerformanceViewModel extends ViewModel
{
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

    public function manager()
    {
        return person()->manager->only('id', 'full_name');
    }

    public function objectives()
    {
        return person()->objectives;
    }
}