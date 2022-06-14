<?php

namespace App\Http\Absences\ViewModels;

use App\Http\Support\ViewModels\ViewModel;

class HolidayViewModel extends ViewModel
{
    public function approved()
    {
        return person()
            ->holidays()
            ->whereApproved()
            ->get();
    }

    public function pending()
    {
        return person()
            ->holidays()
            ->wherePending()
            ->get();
    }

    public function rejected()
    {
        return person()
            ->holidays()
            ->whereRejected()
            ->get();
    }
}
