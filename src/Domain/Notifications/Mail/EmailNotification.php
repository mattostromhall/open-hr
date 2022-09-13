<?php

namespace Domain\Notifications\Mail;

use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailNotification extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        protected EmailNotificationData $data
    ) {
        //
    }

    public function build(): self
    {
        return $this->view('emails.notification')
            ->subject($this->data->subject)
            ->with([
                'body' => $this->data->body,
                'link' => $this->data->link
            ]);
    }
}
