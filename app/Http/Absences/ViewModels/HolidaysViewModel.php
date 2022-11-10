<?php

namespace App\Http\Absences\ViewModels;

use App\Http\Support\ViewModels\ViewModel;

class HolidaysViewModel extends ViewModel
{
    public function active(): string
    {
        return request()->query('active', 'request');
    }

    public function approved()
    {
        return person()
            ->holidays()
            ->select('id', 'start_at', 'finish_at', 'half_day', 'notes')
            ->whereApproved()
            ->orderBy('start_at')
            ->get()
            ->includeDuration();
    }

    public function pending()
    {
        return person()
            ->holidays()
            ->select('id', 'start_at', 'finish_at', 'half_day', 'notes')
            ->wherePending()
            ->orderBy('start_at')
            ->get()
            ->includeDuration();
    }

    public function rejected()
    {
        return person()
            ->holidays()
            ->select('id', 'start_at', 'finish_at', 'half_day', 'notes')
            ->whereRejected()
            ->orderBy('start_at')
            ->get();
    }
}
