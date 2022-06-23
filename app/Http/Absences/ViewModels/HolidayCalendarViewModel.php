<?php

namespace App\Http\Absences\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Absences\Enums\HolidayStatus;
use Domain\Absences\Models\Holiday;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Str;

class HolidayCalendarViewModel extends ViewModel
{
    protected function holidaysWithPerson(): Collection
    {
        return Holiday::query()
            ->with('person:id,first_name,last_name,hex_code')
            ->whereNotRejected()
            ->get();
    }

    public function holidayEvents(): SupportCollection
    {
        return $this->holidaysWithPerson()
            ->map(function ($holiday) {
                return [
                    'title' => $holiday->person->fullName . ' ' . ($holiday->half_day ? $holiday->half_day->value : $holiday->duration->inWeekDays() . ' ' . Str::plural('day', $holiday->duration->inDays())),
                    'start' => $holiday->start_at,
                    'end' => $holiday->finish_at,
                    'color' => $holiday->person->hex_code,
                    'classNames' => $holiday->status === HolidayStatus::PENDING
                        ? 'opacity-50 cursor-pointer'
                        : 'cursor-pointer',
                    'extendedProps' => $holiday->toArray()
                ];
            });
    }
}
