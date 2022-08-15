<?php

namespace App\Http\Performance\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Auth\Models\User;
use Domain\Performance\Models\OneToOne;
use Illuminate\Database\Eloquent\Collection;

class OneToOneInviteViewModel extends ViewModel
{
    public function __construct(protected OneToOne $oneToOne)
    {
        //
    }

    public function oneToOne(): OneToOne
    {
        return $this->oneToOne;
    }

    public function requester(): string
    {
        return $this->oneToOne->requester->full_name;
    }

    public function status(): string
    {
        return $this->oneToOne->status->statusDisplay();
    }
}
