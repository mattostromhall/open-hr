<?php

namespace Domain\Performance\Mail;

use Domain\People\Models\Person;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Models\OneToOne;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OneToOneInvite extends Mailable implements ShouldQueue
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
            ->subject("One-to-one requested")
            ->with([
                'body' => "A One-to-one has been requested by {$this->oneToOne->requester->full_name} at {$this->data->scheduled_at->toDateTimeString()}",
                'link' => route('one-to-one.invite.show', [
                    'one_to_one' => $this->oneToOne
                ])
            ]);
    }
}
