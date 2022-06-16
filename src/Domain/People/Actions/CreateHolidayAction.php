<?php

namespace Domain\People\Actions;

use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;

class CreateHolidayAction
{
    public function execute(HolidayData $data): Holiday
    {
        return Holiday::create([
            'person_id' => $data->person->id,
            'status' => $data->status,
            'start_at' => $data->start_at,
            'finish_at' => $data->finish_at,
            'half_day' => $data->half_day,
            'notes' => $data->notes
        ]);
    }
}
