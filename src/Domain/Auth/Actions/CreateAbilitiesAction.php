<?php

namespace Domain\Auth\Actions;

use Domain\Auth\DataTransferObjects\AbilityData;
use Domain\Auth\Enums\Ability;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Silber\Bouncer\BouncerFacade as Bouncer;

class CreateAbilitiesAction
{
    public function execute(): Collection
    {
        return collect(Ability::cases())
            ->map(
                fn (Ability $ability) =>
                new AbilityData(
                    name: $ability->value,
                    title: Str::of($ability->value)
                        ->ucfirst()
                        ->explode('-')
                        ->join(' ')
                )
            )->map(
                fn (AbilityData $data) =>
                Bouncer::ability()->firstOrCreate([
                    'name' => $data->name,
                    'title' => $data->title
                ])
            );
    }
}
