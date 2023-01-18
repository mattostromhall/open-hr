<?php

namespace App\Http\Absences\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Absences\Enums\HolidayStatus;
use Domain\Absences\Models\Holiday;
use Domain\Absences\Models\Sickness;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Str;

class SicknessCalendarViewModel extends ViewModel
{
    protected function sicknessesWithPerson(): Collection
    {
        return Sickness::query()
            ->with('person:id,first_name,last_name,hex_code')
            ->get();
    }

    public function sicknessEvents(): SupportCollection
    {
        return $this->sicknessesWithPerson()
            ->map(function (Sickness $sickness) {
                return [
                    'title' => $sickness->person->fullName . ' ' . $sickness->duration->inWeekDays() . ' ' . Str::plural('day', $sickness->duration->inWeekDays()),
                    'start' => $sickness->start_at,
                    'end' => $sickness->finish_at,
                    'color' => $sickness->person->hex_code,
                    'classNames' => 'cursor-pointer',
                    'extendedProps' => $sickness->toArray()
                ];
            });
    }
}
