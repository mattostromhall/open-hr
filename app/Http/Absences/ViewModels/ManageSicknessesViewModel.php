<?php

namespace App\Http\Absences\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Absences\Models\Sickness;

class ManageSicknessesViewModel extends ViewModel
{
    public function active(): string
    {
        return request()->query('active', 'report');
    }

    public function directReports()
    {
        return person()->directReports->map(
            fn ($directReport) => $directReport->only('id', 'full_name')
        );
    }

    public function sicknesses()
    {
        return Sickness::query()
            ->select('id', 'start_at', 'finish_at')
            ->forPeople(person()->directReports)
            ->orderBy('start_at')
            ->get()
            ->includeDuration();
    }
}
