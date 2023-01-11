<?php

namespace Domain\Auth\Actions\Contracts;

use Domain\Auth\DataTransferObjects\AbilityData;
use Domain\Auth\Enums\Ability;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Silber\Bouncer\BouncerFacade as Bouncer;

interface CreateAbilitiesActionInterface
{
    public function execute(): Collection;
}
