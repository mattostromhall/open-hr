<?php

namespace App\Http\Dashboard\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Performance\Models\Objective;
use Illuminate\Database\Eloquent\Collection;

class ManagementDashboardViewModel extends ViewModel
{
    public function person()
    {
        return person()->only('id', 'full_name', 'initials', 'position');
    }

    public function holidayRemaining(): int|float
    {
        $allotted = person()->base_holiday_allocation + person()->holiday_carried;

        $taken = person()
            ->holidayThisYear()
            ->get()
            ->numberTaken();

        return $allotted - $taken;
    }

    public function sickDaysRemaining(): int|float
    {
        $allotted = person()->sickness_allocation;

        $taken = person()
            ->sicknessThisYear()
            ->get()
            ->numberTaken();

        return $allotted - $taken;
    }

    public function organisationNotifications()
    {
        return organisation()
            ->notifications()
            ->limit(3)
            ->get()
            ->map(fn ($notification) => $notification->body);
    }

    public function objectives(): Collection
    {
        return Objective::query()
            ->select('id', 'title', 'description')
            ->forPeople(person()->directReports)
            ->current()
            ->get();
    }
}
