<?php

namespace Domain\Absences\Actions;

use Domain\Absences\Actions\Contracts\UpdateHolidayActionInterface;
use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;

class UpdateHolidayAction implements UpdateHolidayActionInterface
{
    public function execute(Holiday $holiday, HolidayData $data): bool
    {
        return $holiday->update([
            'status' => $data->status,
            'start_at' => $data->start_at,
            'finish_at' => $data->finish_at,
            'half_day' => $data->half_day,
            'notes' => $data->notes
        ]);
    }
}
