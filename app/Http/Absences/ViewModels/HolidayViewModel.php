<?php

namespace App\Http\Absences\ViewModels;

use App\Http\Support\ViewModels\ViewModel;

class HolidayViewModel extends ViewModel
{
    public function approved()
    {
        return person()
            ->holidays()
            ->select('start_at', 'finish_at', 'half_day', 'notes')
            ->whereApproved()
            ->orderBy('start_at')
            ->get()
            ->map(function ($holiday) {
                return [
                    'duration' => $holiday->duration->inDays(),
                    ...$holiday->toArray()
                ];
            });
    }

    public function pending()
    {
        return person()
            ->holidays()
            ->select('start_at', 'finish_at', 'half_day', 'notes')
            ->wherePending()
            ->orderBy('start_at')
            ->get()
            ->map(function ($holiday) {
                return [
                    'duration' => $holiday->duration->inDays(),
                    ...$holiday->toArray()
                ];
            });
    }

    public function rejected()
    {
        return person()
            ->holidays()
            ->select('start_at', 'finish_at', 'half_day', 'notes')
            ->whereRejected()
            ->orderBy('start_at')
            ->get();
    }
}
