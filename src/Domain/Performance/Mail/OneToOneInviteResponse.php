<?php

namespace Domain\Performance\Mail;

use Domain\People\Models\Person;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Enums\OneToOneStatus;
use Domain\Performance\Models\OneToOne;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OneToOneInviteResponse extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        protected OneToOne $oneToOne,
        protected OneToOneData $data
    ) {
        //
    }

    public function build(): self
    {
        return $this->view('emails.one-to-one-invite')
            ->subject("A One-to-one has been {$this->status($this->oneToOne->status)}")
            ->with([
                'body' => "A One-to-one, scheduled at {$this->data->scheduled_at->toDateTimeString()}, has been {$this->status($this->oneToOne->status)}",
                'link' => route('one-to-one.invite.show', [
                    'one_to_one' => $this->oneToOne
                ])
            ]);
    }

    protected function status(OneToOneStatus $status): string
    {
        if ($status->value === 1) {
            return 'amended';
        }

        return $status->statusDisplay();
    }
}
