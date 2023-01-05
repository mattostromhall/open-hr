<?php

namespace App\Http\Absences\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Absences\Models\Holiday;
use Illuminate\Database\Eloquent\Collection;

class ManageHolidaysViewModel extends ViewModel
{
    public function active(): string
    {
        return request()->query('active', 'pending');
    }

    public function approved()
    {
        return Holiday::query()
            ->select('id', 'start_at', 'finish_at', 'half_day', 'notes')
            ->forPeople(person()->directReports)
            ->whereApproved()
            ->orderBy('start_at')
            ->get()
            ->includeDuration();
    }

    public function pending()
    {
        return Holiday::query()
            ->select('id', 'start_at', 'finish_at', 'half_day', 'notes')
            ->forPeople(person()->directReports)
            ->select('id', 'start_at', 'finish_at', 'half_day', 'notes')
            ->wherePending()
            ->orderBy('start_at')
            ->get()
            ->includeDuration();
    }

    public function rejected(): Collection
    {
        return Holiday::query()
            ->select('id', 'start_at', 'finish_at', 'half_day', 'notes')
            ->forPeople(person()->directReports)
            ->select('id', 'start_at', 'finish_at', 'half_day', 'notes')
            ->whereRejected()
            ->orderBy('start_at')
            ->get();
    }
}
