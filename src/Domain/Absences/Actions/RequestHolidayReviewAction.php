<?php

namespace Domain\Absences\Actions;

use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Mail\ReviewHolidayRequest;
use Domain\Absences\Models\Holiday;
use Illuminate\Support\Facades\Mail;

class RequestHolidayReviewAction
{
    public function execute(Holiday $holiday, HolidayData $data): void
    {
        $manager = $data->person->manager;

        if (! $manager) {
            return;
        }

        $manager->notifications()->create([
            'title' => 'New holiday request',
            'body' => "Holiday requested by {$data->person->fullName}, click here to review.",
            'link' => route('holiday.review', [
                'holiday' => $holiday
            ])
        ]);

        Mail::to($manager->user->email)
            ->send(new ReviewHolidayRequest($holiday, $data));
    }
}
