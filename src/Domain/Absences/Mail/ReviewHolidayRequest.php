<?php

namespace Domain\Absences\Mail;

use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviewHolidayRequest extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(protected Holiday $holiday, protected HolidayData $data)
    {
        //
    }

    public function build(): static
    {
        return $this->view('emails.review-holiday-request')
            ->subject("Holiday requested by {$this->data->person->fullName}")
            ->with([
                'body' => "Holiday requested by {$this->data->person->fullName}, click below to review.",
                'link' => route('holiday.review.show', [
                    'holiday' => $this->holiday
                ])
            ]);
    }
}
