<?php

namespace App\Http\Absences\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Absences\Models\Holiday;
use Domain\Absences\Models\Sickness;

class SicknessViewModel extends ViewModel
{
    public function __construct(protected Sickness $sickness)
    {
        //
    }

    public function sickness(): Sickness
    {
        return $this->sickness;
    }

    public function logger()
    {
        return $this->sickness->person->full_name;
    }
}
