<?php

namespace App\Http\Absences\ViewModels;

use App\Http\Support\ViewModels\ViewModel;

class SicknessesViewModel extends ViewModel
{
    public function active(): string
    {
        return request()->query('active', 'log');
    }

    public function sicknesses()
    {
        return person()
            ->sicknesses()
            ->select('id', 'start_at', 'finish_at')
            ->orderBy('start_at')
            ->get()
            ->includeDuration();
    }
}
